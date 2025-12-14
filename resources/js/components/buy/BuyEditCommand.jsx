import React, { useState, useEffect } from "react";
import Select from "react-select";
import "bootstrap/dist/css/bootstrap.min.css";
import ReactDOM from "react-dom/client";
import Loader from "../Loader";
import { toast, ToastContainer } from "react-toastify";
import { getDataForCmd, updateBuyCommand } from "../services/buy";
import "./buyStyle.css";
import { Color } from "pspdfkit";

export default function BuyEditCommand({ command }) {
    console.log("to be tested", command);
    const [form, setForm] = useState(() => ({
        client: command
            ? {
                  value: command.supplier.id,
                  label: `${command.supplier.name} (${command.supplier.phone})`,
                  ...command.supplier,
              }
            : null,
        dateFacture: command
            ? command.date_command
            : new Date().toISOString().slice(0, 10),
        montantFacture: command ? command.amount : 0,
        // montantEncaisse: command ? command.montant_encaisse : 0,
        // montantDu: command ? command.montant_du : 0,
        // modePaiement: command
        //     ? { value: command.payments[0]?.mode_id, label: command.payments[0]?.name, ...command.payments }
        //     : [],
        modePaiement: [],
    }));

    const [articlesData, setArticlesData] = useState([]);
    const [suppliers, setSuppliers] = useState([]);
    const [modesPaiement, setModesPaiement] = useState([]);
    const [loading, setLoading] = useState(false);
    const [disableBtn, setDisableBtn] = useState(false);

    const [rows, setRows] = useState(() => {
        if (command && command.purchase_order_lines) {
            return command.purchase_order_lines.map((line) => ({
                article: {
                    id: line.product_id,
                    prix: line.unit_price,
                    taxe: line.taxe,
                    unite: line.unit_measure?.name,
                    description: line.product?.description,
                    label: `${line.product?.product_name} - ${line.product?.id}`,
                },
                description: line.product?.description,
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
            console.log("command", command, command.id);
            const res = await getDataForCmd();
            console.log("data cmd", res);
            if (res.success) {
                const clt = res.data.suppliers.map((c) => ({
                    value: c.id,
                    label: `${c.name} (${c.phone})`, // affichage dans le select
                    ...c, // on garde toutes les infos utiles
                }));
                setSuppliers(clt);

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

        if (statut == "validated") {
            const ok = confirm("Voulez-vous valider cette commande ?");
            if (!ok) return;
        }

        // Construire les données de la commande
        const commandData = {
            ...form,
            supplier_id: form.client?.value || null,
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

        console.log("📤 Données commande :", commandData);
        console.log(
            "📤 Statut cmd : 0 =>  brouillon, 1 => confirmer",
            statut
        );

        setLoading(true);
        setDisableBtn(true);
        try {
            const res = await updateBuyCommand(commandData, command.id);
            console.log("save", res);
            if (res.status == 200) {
                toast.success(res.message || "Commande mise à jour avec succès !!!");
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
                window.location.href = "/dashboard/buy-command-order";
            } else {
                const msg = res.message || "Echec mise à jour de la commande";
                toast.error(msg);
            }
        } catch (error) {
            console.log("Erreur d'update", error);
            toast.error("Echec de mise à jour de commande, erreur serveur !!!");
        } finally {
            setLoading(false);
            setDisableBtn(false);
        }
    };

    return (
        <div className="row m-2">
            <Loader load={loading} />
            <div className="toast-container">
                <ToastContainer limit={3} />
            </div>
            <h4>Modification de la commande N° {command.reference} </h4>
            <div
                className="row g-3 border rounded p-3 mb-4"
                style={{ backgroundColor: "white" }}
            >
                <div className="col-md-4">
                    <label className="form-label">Client *</label>
                    <Select
                        options={suppliers}
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
                                className="fas fa-trash-alt"
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
                                                className="form-control hidden-input"
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
                                        <td>
                                            <input
                                                type="number"
                                                className="form-control hidden-input"
                                                value={row.prix}
                                                min={0}
                                                onChange={(e) => {
                                                    const updatedRows = [
                                                        ...rows,
                                                    ];
                                                    updatedRows[index].prix =
                                                        parseInt(
                                                            e.target.value
                                                        ) || 1;
                                                    setRows(updatedRows);
                                                }}
                                            />
                                        </td>
                                        <td>
                                            <input
                                                type="number"
                                                className="form-control hidden-input"
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
                                            <i
                                                className="fas fa-trash-alt"
                                                style={{ color: "red" }}
                                                onClick={() =>
                                                    handleRemoveRow(index)
                                                }
                                            ></i>
                                        </td>
                                    </tr>
                                );
                            })}
                        </tbody>
                    </table>
                </div>
                <div className="d-flex justify-content-center gap-2 mt-3 pb-3">
                    {/* <button className="btn btn-secondary" disabled={disableBtn}>Annuler</button> */}
                    
                    <button
                        className="btn btn-success btn-sm"
                        disabled={disableBtn}
                        onClick={(e) => {
                            handleSubmit(e, "confirmed");
                        }}
                    >
                        Confirmer
                    </button>
                    {command?.status == "draft" && (
                    <button
                        className="btn btn-primary btn-sm"
                        disabled={disableBtn}
                        onClick={(e) => {
                            handleSubmit(e, "draft");
                        }}
                    >
                        Enregistrer
                    </button>
                    )}
                </div>
            </div>
        </div>
    );
}

const container = document.getElementById("buy-command-edit");
if (container) {
    const Index = ReactDOM.createRoot(container);
    const command = JSON.parse(container.getAttribute("data-command"));

    Index.render(
        <React.StrictMode>
            <BuyEditCommand command={command} />
        </React.StrictMode>
    );
}
