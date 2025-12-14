import React from "react";

const ThermalReceipt = React.forwardRef(
    ({ cartField, totalCart, amountReceived, balance, devise }, ref) => {
        return (
            <div ref={ref} className="ticket">
                <h3 className="text-center">STREET SMART</h3>
                <p className="text-center">POS Ticket</p>
                <hr />

                <div className="info">
                    <span>Date :</span>
                    <span>{new Date().toLocaleString()}</span>
                </div>

                <hr />

                {cartField.map((item, i) => (
                    <div className="row" key={i}>
                        <div>{item.name}</div>
                        <div className="right">
                            {item.quantity} x {item.price}
                        </div>
                        <div className="right">
                            {item.total_price} {devise}
                        </div>
                    </div>
                ))}

                <hr />

                <div className="row bold">
                    <span>Total</span>
                    <span>
                        {totalCart} {devise}
                    </span>
                </div>
                <div className="row">
                    <span>Reçu</span>
                    <span>
                        {amountReceived} {devise}
                    </span>
                </div>
                <div className="row">
                    <span>Rendu</span>
                    <span>
                        {balance} {devise}
                    </span>
                </div>

                <hr />

                <p className="text-center">Merci pour votre achat 🙏</p>
            </div>
        );
    }
);

export default ThermalReceipt;
