
const PaymentModal = (props) => {

    return (
        <div className="modal fade" id="modal-payment">
            <div className="modal-dialog">
                <div className="modal-content">
                    <div className="modal-header">
                        <p className="modal-title h4" style={{ textAlign: "center" }}>Valider le paiement</p>
                        <button type="button" className="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div className="modal-body">
                        <div class="row">
                            <div class="col-sm-6 mb-2">
                                <div class="form-group">
                                    <label for="app_name">Montant Total<em>*</em></label>
                                    <input type="text" value={props.totalAmount} readOnly class="form-control form-control-border border-width-2 required"
                                        name="totalAmount" id="app_name" />
                                </div>
                            </div>
                            <div class="col-sm-6 mb-2">
                                <div class="form-group">
                                    <label for="app_phone">Montant perçu <em>*</em></label>
                                    <input type="text" class="form-control form-control-border border-width-2 required"
                                        value={props.amount_received}
                                        name="received_amount" id="app_phone" />
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    );
}

export default PaymentModal;

