import React from "react";

function PaymentModal({
    show,
    onClose,
    cartField,
    totalCart,
    amountReceived,
    setAmountReceived,
    balance,
    onConfirm,
    onConfirmAndPrint,
    devise,
}) {
    if (!show) return null;

    return (
        <div className="modal fade show d-block" tabIndex="-1" style={{ zIndex: 1055 }}>
            <div className="modal-dialog modal-lg modal-dialog-centered">
                <div className="modal-content">
                    {/* HEADER */}
                    <div className="modal-header">
                        <h5 className="modal-title">
                            Confirmation de paiement
                        </h5>
                        <button
                            className="btn-close"
                            onClick={onClose}
                        ></button>
                    </div>

                    {/* BODY */}
                    <div className="modal-body">
                        {/* PANIER */}
                        <table className="table table-sm">
                            <thead className="table-light">
                                <tr>
                                    <th>Produit</th>
                                    <th>Qté</th>
                                    <th className="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                {cartField.map((item, i) => (
                                    <tr key={i}>
                                        <td>{item.name}</td>
                                        <td>{item.quantity}</td>
                                        <td className="text-end">
                                            {item.total_price} {devise}
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>

                        <hr />

                        {/* CHAMPS PAIEMENT */}
                        <div className="row g-3">
                            <div className="col-md-4">
                                <label className="form-label">
                                    Montant facture
                                </label>
                                <input
                                    type="number"
                                    className="form-control"
                                    value={totalCart}
                                    readOnly
                                />
                            </div>

                            <div className="col-md-4">
                                <label className="form-label">
                                    Montant perçu
                                </label>
                                <input
                                    type="number"
                                    className="form-control"
                                    value={amountReceived}
                                    onChange={(e) =>
                                        setAmountReceived(e.target.value)
                                    }
                                />
                            </div>

                            <div className="col-md-4">
                                <label className="form-label">Reste</label>
                                <input
                                    type="number"
                                    className={`form-control ${
                                        balance < 0 ? "is-invalid" : ""
                                    }`}
                                    value={balance}
                                    readOnly
                                />
                            </div>
                        </div>
                    </div>

                    {/* FOOTER */}
                    <div className="modal-footer">
                        <button className="btn btn-secondary" onClick={onClose}>
                            Annuler
                        </button>

                        <button
                            className="btn btn-success"
                            disabled={balance < 0}
                            onClick={onConfirm}
                        >
                            Confirmer la facture
                        </button>

                        <button
                            className="btn btn-primary"
                            disabled={balance < 0}
                            onClick={onConfirmAndPrint}
                        >
                            Confirmer & Imprimer
                        </button>
                    </div>
                </div>
            </div>

            {/* BACKDROP */}
            {/* <div className="modal-backdrop fade show" style={{ zIndex: 1050 }}></div> */}
        </div>
    );
}

export default PaymentModal;
