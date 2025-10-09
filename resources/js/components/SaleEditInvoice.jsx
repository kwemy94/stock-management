import React, { useState, useEffect } from "react";
import Select from "react-select";
import "bootstrap/dist/css/bootstrap.min.css";
import ReactDOM from "react-dom/client";
import { addSaleInvoice, getDataForInvoice, updateSaleInvoice } from "./services/sale";
import Loader from "./Loader";
import { toast, ToastContainer } from "react-toastify";
import { stringify } from "postcss";

export default function SaleEditInvoice({invoice}) {
    // État de l’en-tête
    // const [form, setForm] = useState({
    //     client: null,
    //     dateFacture: new Date().toISOString().slice(0, 10),
    //     montantFacture: 0,
    //     montantEncaisse: 0,
    //     montantDu: 0,
    //     modePaiement: [],
    // });

    const [form, setForm] = useState(() => ({
        client: invoice
            ? { value: invoice.customer.id, label: `${invoice.customer.name} (${invoice.customer.phone})`, ...invoice.customer }
            : null,
        dateFacture: invoice ? invoice.date : new Date().toISOString().slice(0, 10),
        montantFacture: invoice ? invoice.montant_facture : 0,
        montantEncaisse: invoice ? invoice.montant_encaisse : 0,
        montantDu: invoice ? invoice.montant_du : 0,
        modePaiement: invoice
            ? { value: invoice.payments[0]?.mode_id, label: invoice.payments[0]?.name, ...invoice.payments }
            : [],
    }));

    const [articlesData, setArticlesData] = useState([]);
    const [clients, setClients] = useState([]);
    const [modesPaiement, setModesPaiement] = useState([]);
    const [loading, setLoading] = useState(false);
    const [disableBtn, setDisableBtn] = useState(false);

    // Lignes d’articles
    // const [rows, setRows] = useState([
    //     {
    //         article: null,
    //         description: "",
    //         quantite: 1,
    //         prix: 0,
    //         taxe: 0,
    //         unite: "",
    //         remise: 0,
    //     },
    // ]);

    const [rows, setRows] = useState(() => {
        if (invoice && invoice.invoice_lines) {
            return invoice.invoice_lines.map((line) => ({
                article: {
                    id: line.product_id,
                    prix: line.unit_price,
                    taxe: line.taxe,
                    unite: line.unit_measure?.name,
                    description: line.product.description,
                    label: `${line.product.product_name} - ${line.product.id}`,
                },
                description: line.product.description,
                quantite: line.quantity,
                prix: line.unit_price,
                taxe: line.taxe,
                unite: line.unit_measure?.name,
                remise: line.remise,
            }));
        }
        return [
            {
                article: null,
                description: "",
                quantite: 1,
                prix: 0,
                taxe: 0,
                unite: "",
                remise: 0,
            },
        ];
    });

    useEffect(() => {
        loadData();
    }, []);

    const loadData = async () => {
        try {
            console.log('invoice', invoice, invoice.id, invoice.payments[0]);
            const res = await getDataForInvoice();
            console.log("data", res);
            if (res.success) {
                const clt = res.data.customers.map((c) => ({
                    value: c.id,
                    label: `${c.name} (${c.phone})`, // affichage dans le select
                    ...c, // on garde toutes les infos utiles
                }));
                setClients(clt);

                const prod = res.data.products.map((p) => ({
                    id: p.id,
                    prix: p.sale_price,
                    taxe: 0,
                    unite: p?.unit_measure?.name,
                    label: `${p.product_name} - ${p.id}`, // affichage
                    description: p.product_name,
                    ...p, // garder toutes les infos
                }));
                setArticlesData(prod);

                const payes = res.data.paymentModes.map((p) => ({
                    value: p.id,
                    label: `${p.name} `, // affichage dans le select
                    ...p, // on garde toutes les infos utiles
                }));
                setModesPaiement(payes);
                console.log("to use", res);
            } else {
                const msg = res.message || "Echec sauvegarde facture";
                toast.error(msg);
            }
        } catch (error) {
            console.log("mes eror", error);
        }
    };

    // Recalcul automatique du montant facture et du montant dû
    useEffect(() => {
        let montantFacture = 0;
        rows.forEach((row) => {
            if (row.article) {
                const montantHT =
                    row.quantite * row.prix * (1 - row.remise / 100);
                const montantTaxe = montantHT * (row.taxe / 100);
                const montantTTC = montantHT + montantTaxe;
                montantFacture += montantTTC;
            }
        });

        const montantDu = montantFacture - form.montantEncaisse;

        setForm((prev) => ({
            ...prev,
            montantFacture,
            montantDu,
        }));
    }, [rows, form.montantEncaisse]);

    // Ajouter une ligne seulement si la précédente a un article sélectionné
    const handleAddRow = () => {
        const lastRow = rows[rows.length - 1];
        if (lastRow.article) {
            setRows([
                ...rows,
                {
                    article: null,
                    description: "",
                    quantite: 1,
                    prix: 0,
                    taxe: 0,
                    unite: "",
                    remise: 0,
                },
            ]);
        } else {
            alert(
                "Veuillez sélectionner un article avant d'ajouter une nouvelle ligne !"
            );
        }
    };

    const handleRemoveRow = (index) => {
        const updatedRows = rows.filter((_, i) => i !== index);
        setRows(updatedRows);
    };

    // Quand on choisit un article, remplir automatiquement les colonnes
    const handleSelectArticle = (index, selectedArticle) => {
        const updatedRows = [...rows];
        updatedRows[index] = {
            ...updatedRows[index],
            article: selectedArticle,
            description: selectedArticle.description,
            prix: selectedArticle.prix,
            taxe: selectedArticle.taxe,
            unite: selectedArticle.unite,
        };
        setRows(updatedRows);
    };

    // Empêcher qu’un article apparaisse dans plusieurs lignes
    const getAvailableArticles = (index) => {
        const selectedIds = rows.map((r) => r.article?.id).filter(Boolean);
        return articlesData.filter(
            (art) =>
                !selectedIds.includes(art.id) ||
                rows[index].article?.id === art.id
        );
    };
    // Fonction de soumission
    const handleSubmit = async (e, statut) => {
        e.preventDefault();

        // Vérification des champs obligatoires
        if (!form.dateFacture || !form.client || !form.modePaiement) {
            alert(
                "⚠️ Merci de remplir tous les champs obligatoires (*) avant de confirmer."
            );
            return;
        }

        if (rows.length === 0 || !rows[0].article) {
            alert("⚠️ Merci d’ajouter au moins un article avant de confirmer.");
            return;
        }

        if (statut == "confirmed" && form.montantEncaisse == 0) {
            const ok = confirm("⭕❌ Voulez-vous confirmer sans encaisser ?");
            if (!ok) return;
        } else {
            if (
                statut == "confirmed" &&
                form.montantFacture != form.montantEncaisse
            ) {
                const ok = confirm(
                    "♻ Montant à encaisser différent du montant de la facture. Voulez-vous confirmer cet encaisser ?"
                );
                if (!ok) return;
            }
        }

        // Construire les données de la facture
        const invoiceData = {
            ...form,
            client: form.client?.value || null,
            status: statut,
            modePaiement: form.modePaiement?.value || null,
            // listePrix: form.listePrix?.value || null,
            lines: rows.map((row) => ({
                product_id: row.article?.id,
                // description: row.description,
                quantity: row.quantite,
                unit_price: row.prix,
                taxe: row.taxe,
                // unite: row.unite,
                remise: row.remise,
            })),
        };

        console.log("📤 Données facture :", invoiceData);
        console.log(
            "📤 Statut facture : 0 =>  brouillon, 1 => confirmer",
            statut
        );

        setLoading(true);
        setDisableBtn(true);
        try {
            const res = await updateSaleInvoice(invoiceData, invoice.id);
            console.log("save", res);
            if (res.status == 200) {
                toast.success(res.message || "Facture créer avec succès !!!");
                setForm({
                    client: null,
                    dateFacture: new Date().toISOString().slice(0, 10),
                    montantFacture: 0,
                    montantEncaisse: 0,
                    montantDu: 0,
                    modePaiement: [],
                });
                setRows([
                    {
                        article: null,
                        description: "",
                        quantite: 1,
                        prix: 0,
                        taxe: 0,
                        unite: "",
                        remise: 0,
                    },
                ]);
                window.location.href = "/sale-invoice/true";

            } else {
                const msg = res.message || "Echec mise à jour de la facture";
                toast.error(msg);
            }
        } catch (error) {
            console.log("Erreur d'update", error);
            toast.error("Echec de mise à jour de facture");
        } finally {
            setLoading(false);
            setDisableBtn(false);
        }
    };

    return (
        <div className="container mt-4">
            <Loader load={loading} />
            <div className="toast-container">
                <ToastContainer limit={3} />
            </div>
            <h4>Modification facture N°  {invoice.invoice_number} </h4>
            <div
                className="row g-3 border rounded p-3 mb-4"
                style={{ backgroundColor: "white" }}
            >
                <div className="col-md-4">
                    <label className="form-label">Client *</label>
                    <Select
                        options={clients}
                        value={form.client}
                        onChange={(v) => setForm({ ...form, client: v })}
                        placeholder="Sélectionner un client"
                    />
                </div>
                {/* <div className="col-md-4">
                    <label className="form-label">Site *</label>
                    <Select
                        options={sites}
                        value={form.site}
                        onChange={(v) => setForm({ ...form, site: v })}
                    />
                </div> */}
                <div className="col-md-4">
                    <label className="form-label">Mode de paiement *</label>
                    <Select
                        options={modesPaiement}
                        value={form.modePaiement}
                        onChange={(v) => setForm({ ...form, modePaiement: v })}
                    />
                </div>

                <div className="col-md-3">
                    <label className="form-label">Date facture *</label>
                    <input
                        type="date"
                        className="form-control"
                        value={form.dateFacture}
                        onChange={(e) =>
                            setForm({ ...form, dateFacture: e.target.value })
                        }
                    />
                </div>
                {/* <div className="col-md-3">
                    <label className="form-label">Échéance</label>
                    <input
                        type="date"
                        className="form-control"
                        value={form.echeance}
                        onChange={(e) =>
                            setForm({ ...form, echeance: e.target.value })
                        }
                    />
                </div> */}
                <div className="col-md-3">
                    <label className="form-label">Montant facture</label>
                    <input
                        type="text"
                        className="form-control"
                        value={form?.montantFacture}
                        readOnly
                    />
                </div>
                <div className="col-md-3">
                    <label className="form-label">Montant dû</label>
                    <input
                        type="text"
                        className="form-control"
                        value={form.montantDu}
                        readOnly
                    />
                </div>

                <div className="col-md-3">
                    <label className="form-label">Montant encaissé</label>
                    <input
                        type="number"
                        className="form-control"
                        value={form.montantEncaisse}
                        onChange={(e) =>
                            setForm({
                                ...form,
                                montantEncaisse:
                                    parseFloat(e.target.value) || 0,
                            })
                        }
                    />
                </div>

                <div className="col-12">
                    <div className="d-flex mb-2">
                        <button
                            className="btn btn-success btn-sm me-2"
                            onClick={handleAddRow}
                        >
                            + Add
                        </button>
                        <button
                            className="btn btn-danger btn-sm"
                            onClick={() => setRows(rows.slice(0, -1))}
                        >
                            <span
                                className="fas fa-trash"
                                aria-hidden="true"
                            ></span>{" "}
                            Delete
                        </button>
                    </div>

                    <table className="table table-bordered">
                        <thead className="table-light">
                            <tr>
                                <th>Article</th>
                                <th>Description</th>
                                <th>Quantité</th>
                                <th>Unité</th>
                                <th>Prix unitaire</th>
                                <th>Remise (%)</th>
                                <th>Montant HT</th>
                                <th>Montant Taxe</th>
                                <th>Montant TTC</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            {rows.map((row, index) => {
                                const montantHT =
                                    row.quantite *
                                    row.prix *
                                    (1 - row.remise / 100);
                                const montantTaxe =
                                    montantHT * (row.taxe / 100);
                                const montantTTC = montantHT + montantTaxe;

                                return (
                                    <tr key={index}>
                                        <td style={{ minWidth: "200px" }}>
                                            <Select
                                                options={getAvailableArticles(
                                                    index
                                                )}
                                                value={row.article}
                                                onChange={(val) =>
                                                    handleSelectArticle(
                                                        index,
                                                        val
                                                    )
                                                }
                                                placeholder="Choisir un article"
                                                isClearable
                                            />
                                        </td>
                                        <td>{row.description}</td>
                                        <td>
                                            <input
                                                type="number"
                                                className="form-control"
                                                value={row.quantite}
                                                onChange={(e) => {
                                                    const updatedRows = [
                                                        ...rows,
                                                    ];
                                                    updatedRows[
                                                        index
                                                    ].quantite =
                                                        parseInt(
                                                            e.target.value
                                                        ) || 1;
                                                    setRows(updatedRows);
                                                }}
                                            />
                                        </td>
                                        <td>{row.unite}</td>
                                        <td>{row.prix}</td>
                                        <td>
                                            <input
                                                type="number"
                                                className="form-control"
                                                value={row.remise}
                                                onChange={(e) => {
                                                    const updatedRows = [
                                                        ...rows,
                                                    ];
                                                    updatedRows[index].remise =
                                                        parseFloat(
                                                            e.target.value
                                                        ) || 0;
                                                    setRows(updatedRows);
                                                }}
                                            />
                                        </td>
                                        <td>{montantHT.toFixed(2)}</td>
                                        <td>{montantTaxe.toFixed(2)}</td>
                                        <td>{montantTTC.toFixed(2)}</td>
                                        <td>
                                            <button
                                                className="btn btn-sm btn-outline-danger"
                                                onClick={() =>
                                                    handleRemoveRow(index)
                                                }
                                            >
                                                X
                                            </button>
                                        </td>
                                    </tr>
                                );
                            })}
                        </tbody>
                    </table>
                </div>
                <div className="d-flex justify-content-center gap-2 mt-3 pb-3">
                    {/* <button className="btn btn-secondary" disabled={disableBtn}>Annuler</button> */}
                    {invoice?.status == "proformat" ? (
                        <button
                            className="btn btn-primary"
                            disabled={disableBtn}
                            onClick={(e) => {
                                handleSubmit(e, "proformat");
                            }}
                        >
                            Enegistrer dévis
                        </button>
                    ) : (
                        <>
                            <button
                                className="btn btn-success"
                                disabled={disableBtn}
                                onClick={(e) => {
                                    handleSubmit(e, "confirmed");
                                }}
                            >
                                Confirmer
                            </button>
                            <button
                                className="btn btn-primary"
                                disabled={disableBtn}
                                onClick={(e) => {
                                    handleSubmit(e, "draft");
                                }}
                            >
                                Enregistrer comme brouillon
                            </button>
                        </>
                    )}
                </div>
            </div>
        </div>
    );
}

const container = document.getElementById("sale-invoice-edit");
if (container) {
    const Index = ReactDOM.createRoot(container);
    const invoice = JSON.parse(container.getAttribute("data-invoice"));

    Index.render(
        <React.StrictMode>
            <SaleEditInvoice invoice={invoice} />
        </React.StrictMode>
    );
}
