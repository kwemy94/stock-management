import React, { useState, useEffect } from "react";
import Select from "react-select";
import "bootstrap/dist/css/bootstrap.min.css";
import ReactDOM from "react-dom/client";
import Loader from "../Loader";
import { toast, ToastContainer } from "react-toastify";
import { addBuyCmd, addBuyReceipt, getDataForCmd } from "../services/buy";
import "./buyStyle.css";

export default function BuyReceipt({ type, commands }) {
    // État de l’en-tête
    const [form, setForm] = useState({
        commande: null,
        supplier: "",
        dateFacture: new Date().toISOString().slice(0, 10),
        montantFacture: 0,
        montantEncaisse: 0,
        montantDu: 0,
        modePaiement: [],
        observation: "",
    });

    const [commandes, setCommandes] = useState([]);
    const [loading, setLoading] = useState(false);
    const [disableBtn, setDisableBtn] = useState(false);

    // Lignes d’articles
    const [rows, setRows] = useState([
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

    useEffect(() => {
        loadData();
    }, []);

    const loadData = async () => {
        console.log("load data", commands);
        const formatted = commands.map((cmd) => ({
            value: cmd.id,
            label: `${cmd.reference} (${cmd.supplier.name})`, // 👈 ce qui s’affiche
            ...cmd, // 👈 toutes les données utiles
        }));

        setCommandes(formatted);
    };

    const determineReceiptStatus = (rows) =>
        rows.some((row) => Number(row.remaining_quantity) > 0)
            ? "partially_received"
            : "received";

    // Fonction de soumission
    const handleSubmit = async (
        e,
        statut = "to_determine",
        another = false
    ) => {
        e.preventDefault();

        if (!form.commande) {
            alert("Veuillez sélectionner une commande");
            return;
        }

        let finalStatus = statut;

        if (statut === "to_determine") {
            finalStatus = determineReceiptStatus(rows);
        }
        if (
            rows.some(
                (r) => r.qte_recue + r.received_quantity > r.qte_commandee
            )
        ) {
            toast.error(
                "La quantité reçue dépasse la quantité restante à livrer"
            );
            return;
        }

        console.log(form);
        // Construire les données de la facture
        const invoiceData = {
            purchase_order_id: form.commande.id,
            receipt_date: form.dateFacture,
            supplier_id: form.commande.supplier_id,
            total_amount: form.montantFacture,
            observation: form.observation,
            status: finalStatus,
            lines: rows.map((row) => ({
                product_id: row.article.id,
                line_id: row.line_id,
                remaining_quantity: row.remaining_quantity,
                quantity_received: row.qte_recue, // réception du jour
                quantity_expected:
                    row.qte_commandee - row.received_quantity - row.qte_recue,
                unit_price: row.unit_price,
                observation: row.observation,
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
            const res = await addBuyReceipt(invoiceData);
            console.log("save", res);
            if (res.status == 201) {
                toast.success(res.message || "Réception créer avec succès !!!");
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
                if (!another) {
                    window.location.href = "/dashboard/buy-reception";
                }
            } else {
                const msg = res.message || "Echec sauvegarde de la commande";
                toast.error(msg);
            }
        } catch (error) {
            console.log("Erreur d'enregistrement", error);
            toast.error("Echec de création de la commande");
        } finally {
            setLoading(false);
            setDisableBtn(false);
        }
    };

    const handleSelectCommande = (cmd) => {
        console.log("📤 Commande sélectionnée :", cmd);
        if (!cmd) {
            setForm((prev) => ({
                ...prev,
                commande: null,
                supplier: "",
                montantFacture: 0,
            }));
            setRows([]);
            return;
        }

        // Fournisseur
        setForm((prev) => ({
            ...prev,
            commande: cmd,
            supplier: cmd.supplier?.name || "",
            montantFacture: Number(cmd?.amount || 0),
        }));

        const mappedRows = cmd.purchase_order_lines.map((line) => {
            const qteCommandee = Number(line.quantity);
            const dejaRecue = Number(line.received_quantity || 0);

            return {
                article: {
                    id: line.product_id,
                    label: line.product?.product_name,
                },
                unite: line.product?.unit_measure?.name || "",
                unit_price: Number(line.unit_price),

                qte_commandee: qteCommandee,
                received_quantity: dejaRecue, // déjà reçu
                qte_recue: 0, // réception du jour
                remaining_quantity: qteCommandee - dejaRecue, // reste avant réception

                line_id: line.id,
                observation: "",
            };
        });

        setRows(mappedRows);
    };

    return (
        <div className="container mt-4">
            <div className="row justify-content-center">
                <div className="col-xl-10 col-lg-11 col-md-12">
                    <Loader load={loading} />
                    <div className="toast-container">
                        <ToastContainer limit={3} />
                    </div>
                    <div className="mb-3 text-center">
                        <h5 className="mb-0 fw-semibold">Nouvelle Réception</h5>
                        <small className="text-muted">
                            Saisie des informations principales
                        </small>
                    </div>
                    <div className="row g-3 bg-white rounded shadow-sm p-3 mb-4">
                        <div className="col-md-4">
                            <label className="form-label">Commande *</label>
                            <Select
                                options={commandes}
                                value={form.commande}
                                onChange={(selected) =>
                                    handleSelectCommande(selected)
                                }
                                placeholder="Sélectionner une commande"
                                isClearable
                            />
                        </div>
                        <div className="col-md-3">
                            <label className="form-label">Fournisseur *</label>
                            <input
                                type="text"
                                className="form-control"
                                value={form.supplier}
                                readOnly
                            />
                        </div>

                        <div className="col-md-3">
                            <label className="form-label">
                                Date réception *
                            </label>
                            <input
                                type="date"
                                className="form-control"
                                value={form.dateFacture}
                                onChange={(e) =>
                                    setForm({
                                        ...form,
                                        dateFacture: e.target.value,
                                    })
                                }
                            />
                        </div>
                        <div className="col-md-3">
                            <label className="form-label">Montant *</label>
                            <input
                                type="text"
                                className="form-control"
                                value={form?.montantFacture?.toFixed(2)}
                                readOnly
                            />
                        </div>
                        <div className="col-md-3">
                            <label className="form-label">Observation</label>
                            <input
                                type="text"
                                className="form-control"
                                value={form?.observation}
                                onChange={(e) =>
                                    setForm({
                                        ...form,
                                        observation: e.target.value,
                                    })
                                }
                            />
                        </div>

                        <div className="col-12">
                            <div className="d-flex align-items-center mb-2 gap-2"></div>
                            <div className="table-responsive">
                                <table className="table table-sm table-hover align-middle">
                                    <thead className="table-light text-muted small">
                                        <tr>
                                            <th>Article/Code</th>
                                            <th>Unité</th>
                                            <th>Qté commandée</th>
                                            <th>PU</th>
                                            <th>Qté reçue</th>
                                            <th>Reste</th>
                                            <th>Observation</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {rows.map((row, index) => (
                                            <tr key={index}>
                                                <td>{row.article?.label}</td>

                                                <td>{row.unite}</td>

                                                <td>{row.qte_commandee}</td>
                                                <td>{row.unit_price}</td>

                                                <td>
                                                    <input
                                                        type="number"
                                                        className="form-control hidden-input"
                                                        style={{
                                                            textAlign: "center",
                                                        }}
                                                        value={row.qte_recue}
                                                        min={0}
                                                        max={
                                                            row.remaining_quantity
                                                        }
                                                        onChange={(e) => {
                                                            const value =
                                                                Number(
                                                                    e.target
                                                                        .value
                                                                );

                                                            const updated = [
                                                                ...rows,
                                                            ];
                                                            const rowData =
                                                                updated[index];

                                                            const maxReceivable =
                                                                rowData.qte_commandee -
                                                                rowData.received_quantity;

                                                            const qteRecue =
                                                                Math.min(
                                                                    value,
                                                                    maxReceivable
                                                                );

                                                            rowData.qte_recue =
                                                                qteRecue;
                                                            rowData.remaining_quantity =
                                                                rowData.qte_commandee -
                                                                rowData.received_quantity -
                                                                qteRecue;

                                                            setRows(updated);
                                                        }}
                                                    />
                                                </td>

                                                <td>
                                                    <input
                                                        type="number"
                                                        className="form-control hidden-input"
                                                        style={{
                                                            textAlign: "center",
                                                        }}
                                                        value={
                                                            row.remaining_quantity
                                                        }
                                                        readOnly
                                                    />
                                                </td>

                                                <td>
                                                    <input
                                                        type="text"
                                                        className="form-control hidden-input"
                                                        style={{
                                                            textAlign: "left",
                                                        }}
                                                        value={row.observation}
                                                        onChange={(e) => {
                                                            const updated = [
                                                                ...rows,
                                                            ];
                                                            updated[
                                                                index
                                                            ].observation =
                                                                e.target.value;
                                                            setRows(updated);
                                                        }}
                                                    />
                                                </td>
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div className="d-flex flex-wrap justify-content-center gap-2 mt-4 pb-3">
                            <button
                                className="btn btn-success btn-sm"
                                disabled={disableBtn}
                                onClick={(e) => {
                                    handleSubmit(e);
                                }}
                            >
                                Reception
                            </button>
                            <button
                                className="btn btn-primary btn-sm"
                                disabled={disableBtn}
                                onClick={(e) => {
                                    handleSubmit(e, "draft");
                                }}
                            >
                                Enregistrer
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

const container = document.getElementById("buy-command-receipt");
if (container) {
    const Index = ReactDOM.createRoot(container);
    const type = container.getAttribute("data-type");
    const commands = JSON.parse(container.dataset.commands);

    Index.render(
        <React.StrictMode>
            <BuyReceipt type={type} commands={commands} />
        </React.StrictMode>
    );
}
