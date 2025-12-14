import React, { useEffect, useRef, useState } from "react";
import ReactDOM from "react-dom/client";
import axios from "axios";
import Loader from "./Loader";
import { ToastContainer, toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";
import useScanDetection from "use-scan-detection";
import { QrReader } from "react-qr-reader";
import PaymentModal from "./PaymentModal";
import { Color } from "pspdfkit";
import ThermalReceipt from "./ThermalReceipt";
import './ticket.css';

function Pos() {
    const [products, setProducts] = useState([]);

    // Copie des prod pour afficher par catégorie
    const [copyProducts, setCopyProducts] = useState();
    const [customers, setCustomers] = useState();
    const [searchProduct, setSearchProduct] = useState("");
    const [categories, setCategories] = useState([]);
    const [setting, setSetting] = useState();
    const [loading, setLoading] = useState(true);
    const [totalCart, setTotalCart] = useState(0);
    const [customer, setCustomer] = useState("");
    const [disableBtn, setDisableBtn] = useState(false);
    // const [amount_received, setAmountReceived] = useState();
    const [amountReceived, setAmountReceived] = useState(0);
    const [showPaymentModal, setShowPaymentModal] = useState(false);
    const [balance, setBalance] = useState(0);

    const qrRf = useRef(null);

    const printRef = useRef();
    const [cartField, setCartFiel] = useState([
        // { prod_id: '', name: '', quantity: '', price: '' }
    ]);

    useEffect(() => {
        loadData();
    }, []);

    useEffect(() => {
        setBalance(Number(amountReceived || 0) - Number(totalCart));
    }, [amountReceived, totalCart]);

    useEffect(() => {
        console.log("total");
        setTotalCart(
            cartField.reduce((total, elt) => {
                return (total += elt.total_price);
            }, 0)
        );
    }, [cartField]);

    const loadData = () => {
        axios
            .get("/dashboard/pos-data-loading")
            .then((res) => {
                console.log(res);
                setProducts(res.data.products);
                setCopyProducts(res.data.products);
                setCustomers(res.data.customers);
                setCategories(res.data.categories);
                setSetting(res.data.setting);

                setLoading(false);
            })
            .catch((err) => {
                console.log(err);
                setLoading(false);
            });
    };

    const productFilter = products?.filter((productSearch) => {
        if (
            productSearch.product_name
                .toLowerCase()
                .match(searchProduct.toLowerCase())
        ) {
            return productSearch.product_name
                .toLowerCase()
                .match(searchProduct.toLowerCase());
        }
    });

    // Selection des produits par categorie
    const ParCategorie = (id) => {
        // Selection de tous les produits
        console.log(id);
        console.log(copyProducts);
        if (id == 0) {
            setProducts(copyProducts);
        } else {
            const prodCategorie = copyProducts?.filter((prod) => {
                return prod.category.id == id ? prod : "";
            });

            setProducts(prodCategorie);
        }
    };

    const selectProduct = (id) => {
        let foundProd = cartField?.find((elt) => elt.prod_id == id);

        if (foundProd) {
            if (decrementProductQuantity(id) != -5000000) {
                cartField.find((elt) => {
                    elt.prod_id == id
                        ? // ? (elt.price += (foundProd.price / foundProd.quantity), elt.quantity = parseInt(elt.quantity) + 1)
                          ((elt.total_price += foundProd.price),
                          (elt.quantity = parseInt(elt.quantity) + 1))
                        : "";
                });
                // toast.success('Article ajouté!');
            } else {
                toast.warning("Oups ! Stock épuisé");
            }
        } else {
            // let newAddItem = copyProducts.find(elt => elt.id == id ? elt : '');
            let newAddItem = products.find((elt) => (elt.id == id ? elt : ""));
            console.log(newAddItem);
            // if (newAddItem.stock_quantity > 0) {
            if (decrementProductQuantity(id) != -5000000) {
                setCartFiel([
                    ...cartField,
                    {
                        prod_id: newAddItem.id,
                        name: newAddItem.product_name,
                        quantity: 1,
                        price: newAddItem.sale_price,
                        total_price: newAddItem.sale_price,
                    },
                ]);

                // toast.success('Article ajouté!');
            } else {
                toast.warning("Oups ! Stock épuisé");
            }
        }
        console.log(cartField);
        setTotalCart(
            // cartField.reduce((total, elt) => { return total += elt.price; }, 0)
            cartField.reduce((total, elt) => {
                return (total += elt.total_price);
            }, 0)
        );

        console.log("set de la quantité dans le menu de droite");
    };

    const deleteProdInCart = (e, id) => {
        e.preventDefault();

        // Restore quantity before delete
        let prod_delete = cartField.find((elt) => elt.prod_id == id);
        restoreProductQuantity(id, prod_delete.quantity);

        let newListProd = cartField.filter((elt) => elt.prod_id != id);
        setCartFiel(newListProd);

        setTotalCart(
            // newListProd.reduce((total, elt) => { return total += elt.price; }, 0)
            newListProd.reduce((total, elt) => {
                return (total += elt.total_price);
            }, 0)
        );
    };

    const restoreProductQuantity = (id, add_quantity = 0) => {
        setProducts((prev) =>
            prev.map((prod) =>
                prod.id === id
                    ? {
                          ...prod,
                          stock_quantity:
                              parseInt(prod.stock_quantity) +
                              parseInt(add_quantity),
                      }
                    : prod
            )
        );
    };

    const decrementProductQuantity = (id, remove_quantity = 1) => {
        if (remove_quantity === 0) return;

        setProducts((prev) =>
            prev.map((prod) => {
                if (prod.id === id) {
                    const newQty =
                        parseInt(prod.stock_quantity) -
                        parseInt(remove_quantity);

                    if (newQty < 0) return prod;

                    return {
                        ...prod,
                        stock_quantity: newQty,
                    };
                }
                return prod;
            })
        );
    };

    const changeProductQuantity = (e, index) => {
        let val = parseInt(e.target.value);

        if (isNaN(val) || val < 1) {
            toast.error("Quantité invalide");
            return;
        }

        let tmp_cartField = [...cartField];
        let tmp = { ...tmp_cartField[index] };

        let current_prod = products.find((elt) => elt.id === tmp.prod_id);

        let diff = val - tmp.quantity; // différence réelle

        // Vérification du stock
        if (diff > 0 && current_prod.stock_quantity < diff) {
            toast.warning("Stock insuffisant");
            return;
        }

        // Mise à jour du stock
        decrementProductQuantity(tmp.prod_id, diff);

        // Mise à jour du panier
        tmp.quantity = val;
        tmp.total_price = val * tmp.price;

        tmp_cartField[index] = tmp;
        setCartFiel(tmp_cartField);
    };

    const handleSubmit = () => {
        console.log(cartField);

        if (cartField.length == 0) {
            toast.warning("Panier vide");
            return;
        }

        setLoading(true);
        setDisableBtn(true);
        axios
            .post(
                "/dashboard/order",
                {
                    cartField,
                    customer,
                    totalCart,
                },
                {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    "'Access-Control-Allow-Origin'": "*",
                }
            )
            .then(async (res) => {
                console.log(res);
                setCartFiel([]);
                await loadData();
                toast.success("Commande enregistrée !");
                setDisableBtn(false);
            })
            .catch((err) => {
                console.log(err);
                setLoading(false);
                toast.error("Echec !", false, "error");
                setDisableBtn(false);
            });
    };

    useEffect(() => {
        setCopyProducts(products);
    }, [products]);

    const findProductWithBarcode = (code) => {
        let product = products.find((elt) => elt.code == code);

        if (product) {
            selectProduct(product.id);

            // toast.success('Produit ajouté !');
        } else {
            // toast.error('Produit non existant !');
        }
    };

    const handleScanBarecode = (e) => {
        e.preventDefault();
        let code = e.target.value;
        e.target.value = "";

        findProductWithBarcode(code);
    };

    // reinitialiser les produits en cliquant sur le btn annuler
    const resetCartFiel = () => {
        // solution provisoire
        console.log(cartField);
        if (cartField.length > 0) {
            for (let k = 0; k < cartField.length; k++) {
                // Restore quantity before delete
                // let prod_delete = cartField.find(elt => elt.prod_id == id);
                restoreProductQuantity(
                    cartField[k].prod_id,
                    cartField[k].quantity
                );
                console.log(k);
            }
            setCartFiel([]);
        }
    };

    // Utilisation du lecteur de code barre pour inserer le produit
    useScanDetection({
        onComplete: findProductWithBarcode,
        minLength: 3,
    });

    // Scanner le codebare en cliquant sur btn de scan de l'app
    const scanCode = () => {
        qrRf.current.openImageDialog();
    };

    const handleErrorFile = (err) => {
        console.log(err);
    };

    const handleScanFile = (res) => {
        if (res) {
            findProductWithBarcode(res);
        }
    };

    const confirmInvoice = async () => {
        await handleSubmit();
        setShowPaymentModal(false);
        setAmountReceived(0);
    };

    const confirmAndPrint = async () => {
    await handleSubmit();

    setTimeout(() => {
        window.print();
    }, 500);

    setShowPaymentModal(false);
    setAmountReceived(0);
};


    return (
        <>
            <div className="row g-3">
                <div className="toast-container">
                    <ToastContainer limit={3} />
                </div>

                {/* PANIER / CAISSE */}
                <div className="col-lg-4 col-md-5">
                    <div className="card shadow-sm h-100">
                        <div className="card-body">
                            {/* BARCODE / CLIENT */}
                            <div className="row g-2 mb-3 align-items-center">
                                <div className="col-12">
                                    <form>
                                        <input
                                            type="search"
                                            className="form-control"
                                            placeholder="Scanner un code-barres…"
                                            autoFocus
                                            onKeyDown={(e) =>
                                                e.key === "Enter" &&
                                                handleScanBarecode(e)
                                            }
                                        />
                                    </form>
                                </div>

                                <div className="col-6">
                                    <button
                                        type="button"
                                        title="Scan code"
                                        onClick={() => scanCode()}
                                        className="btn btn-outline-warning w-100"
                                    >
                                        <i className="fa fa-qrcode me-1"></i>{" "}
                                        Scan
                                    </button>
                                </div>

                                <div className="col-6">
                                    <select
                                        className="form-select"
                                        onChange={(e) =>
                                            setCustomer(e.target.value)
                                        }
                                    >
                                        <option value="">Client inconnu</option>
                                        {customers?.map((customer, i) => (
                                            <option value={customer.id} key={i}>
                                                {customer.name}
                                            </option>
                                        ))}
                                    </select>
                                </div>
                            </div>

                            {/* TABLE PANIER */}
                            <div className="table-responsive mb-3">
                                <table className="table table-sm align-middle">
                                    <thead className="table-light">
                                        <tr>
                                            <th>Produit</th>
                                            <th style={{ width: 80 }}>Qté</th>
                                            <th className="text-end">PU</th>
                                            <th className="text-end">Total</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {cartField.map((prod, i) => (
                                            <tr key={i}>
                                                <td className="fw-semibold">
                                                    {prod.name.substring(0, 10)}
                                                </td>
                                                <td>
                                                    <input
                                                        onChange={(e) =>
                                                            changeProductQuantity(
                                                                e,
                                                                i
                                                            )
                                                        }
                                                        type="number"
                                                        min={1}
                                                        step={0.5}
                                                        value={prod.quantity}
                                                        className="form-control form-control-sm text-center"
                                                    />
                                                </td>
                                                <td className="text-end">
                                                    {prod.price}
                                                </td>
                                                <td className="text-end fw-bold">
                                                    {prod.total_price}
                                                </td>
                                                <td className="text-end">
                                                    <button
                                                        className="btn btn-outline-danger btn-sm"
                                                        onClick={(e) =>
                                                            deleteProdInCart(
                                                                e,
                                                                prod.prod_id
                                                            )
                                                        }
                                                    >
                                                        <i className="fas fa-times"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                            </div>

                            {/* TOTAL */}
                            <div className="d-flex justify-content-between align-items-center mb-3">
                                <span className="text-muted">Total</span>
                                <h5 className="mb-0">
                                    {totalCart}{" "}
                                    {setting?.map((sett, key) => (
                                        <span key={key}>{sett.devise}</span>
                                    ))}
                                </h5>
                            </div>

                            {/* ACTIONS */}
                            <div className="d-flex gap-2">
                                <button
                                    type="button"
                                    onClick={() => resetCartFiel()}
                                    className="btn btn-outline-secondary w-50"
                                >
                                    Annuler
                                </button>
                                <button
                                    type="button"
                                    disabled={
                                        disableBtn || cartField.length === 0
                                    }
                                    onClick={() => setShowPaymentModal(true)}
                                    className="btn btn-success w-50"
                                >
                                    Valider
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {/* PRODUITS */}
                <div className="col-lg-8 col-md-7">
                    <div className="card shadow-sm h-100">
                        <div className="card-body">
                            <Loader load={loading} />

                            {/* FILTRES */}
                            <div className="row g-2 mb-3">
                                <div className="col-sm-6">
                                    <select
                                        className="form-select"
                                        onChange={(e) =>
                                            ParCategorie(e.target.value)
                                        }
                                    >
                                        <option value="0">
                                            Toutes catégories
                                        </option>
                                        {categories?.map((cat, i) => (
                                            <option value={cat.id} key={i}>
                                                {cat.name}
                                            </option>
                                        ))}
                                    </select>
                                </div>
                                <div className="col-sm-6">
                                    <input
                                        type="search"
                                        onChange={(e) =>
                                            setSearchProduct(e.target.value)
                                        }
                                        className="form-control"
                                        placeholder="Rechercher un produit…"
                                    />
                                </div>
                            </div>

                            {/* GRID PRODUITS */}
                            <div className="row g-3">
                                {productFilter?.map((prod, i) => (
                                    <div
                                        className="col-6 col-sm-4 col-md-3 col-xl-2"
                                        key={i}
                                        onClick={() => selectProduct(prod.id)}
                                    >
                                        <div className="card text-center h-100 product-card">
                                            <div className="card-body p-2">
                                                <img
                                                    src="http://localhost:8000/images/default_product.png"
                                                    alt=""
                                                    className="img-fluid mb-2"
                                                    style={{ maxHeight: 60 }}
                                                />
                                                <small className="fw-semibold d-block">
                                                    {prod.product_name}
                                                </small>
                                                <small className="text-muted">
                                                    Stock :{" "}
                                                    {prod.stock_quantity}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div style={{ display: "none" }}>
                <ThermalReceipt
                    ref={printRef}
                    cartField={cartField}
                    totalCart={totalCart}
                    amountReceived={amountReceived}
                    balance={balance}
                    devise={setting?.[0]?.devise}
                />
            </div>

            <PaymentModal
                show={showPaymentModal}
                onClose={() => setShowPaymentModal(false)}
                cartField={cartField}
                totalCart={totalCart}
                amountReceived={amountReceived}
                setAmountReceived={setAmountReceived}
                balance={balance}
                devise={setting?.[0]?.devise}
                onConfirm={confirmInvoice}
                onConfirmAndPrint={confirmAndPrint}
            />
        </>
    );
}

export default Pos;

if (document.getElementById("pos")) {
    const Index = ReactDOM.createRoot(document.getElementById("pos"));

    Index.render(
        <React.StrictMode>
            <Pos />
        </React.StrictMode>
    );
}
