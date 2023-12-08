import React, { useEffect, useRef, useState } from 'react';
import ReactDOM from 'react-dom/client';
import axios from 'axios';
import Loader from './Loader';
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
import useScanDetection from 'use-scan-detection';
import { QrReader } from 'react-qr-reader';
import PaymentModal from './PaymentModal';

function Pos() {

  const [products, setProducts] = useState();

  // Copie des prod pour afficher par catégorie
  const [copyProducts, setCopyProducts] = useState();
  const [customers, setCustomers] = useState();
  const [searchProduct, setSearchProduct] = useState('');
  const [categories, setCategories] = useState([]);
  const [setting, setSetting] = useState();
  const [loading, setLoading] = useState(true);
  const [totalCart, setTotalCart] = useState(0);
  const [customer, setCustomer] = useState('');
  const [disableBtn, setDisableBtn] = useState(false);
  const [amount_received, setAmountReceived] = useState();

  const qrRf = useRef(null);

  const [cartField, setCartFiel] = useState([
    // { prod_id: '', name: '', quantity: '', price: '' }
  ]);

  useEffect(() => {
    loadData();
  }, []);

  useEffect(() => {
    console.log('total');
    setTotalCart(
      cartField.reduce((total, elt) => { return total += elt.total_price; }, 0)
    );
  }, [cartField]);

  const loadData = () => {
    axios.get('/pos-data-loading').then((res) => {
      console.log(res);
      setProducts(res.data.products);
      setCopyProducts(res.data.products);
      setCustomers(res.data.customers);
      setCategories(res.data.categories);
      setSetting(res.data.setting)

      setLoading(false);

    }).catch((err) => {
      console.log(err);
      setLoading(false);
    });
  }




  const productFilter = products?.filter(productSearch => {

    if (productSearch.product_name.toLowerCase().match(searchProduct.toLowerCase())) {
      return productSearch.product_name.toLowerCase().match(searchProduct.toLowerCase())
    }

    // if (productSearch.numero_comptoir.toLowerCase().match(searchInput.toLowerCase())) {
    //     return productSearch.numero_comptoir.toLowerCase().match(searchInput.toLowerCase())
    // }


  })

  // Selection des produits par categorie
  const ParCategorie = (id) => {
    // Selection de tous les produits
    console.log(id);
    console.log(copyProducts);
    if (id == 0) {
      setProducts(copyProducts);
    } else {
      const prodCategorie = copyProducts?.filter(prod => {
        return prod.category.id == id ? prod : '';
      });

      setProducts(prodCategorie);
    }
  }


  const selectProduct = (id) => {

    let foundProd = cartField?.find((elt) => elt.prod_id == id);

    if (foundProd) {
      if (decrementProductQuantity(id) != -5000000) {
        cartField.find((elt) => {
          elt.prod_id == id
            // ? (elt.price += (foundProd.price / foundProd.quantity), elt.quantity = parseInt(elt.quantity) + 1)
            ? (elt.total_price += foundProd.price, elt.quantity = parseInt(elt.quantity) + 1)
            : '';

        });
        // toast.success('Article ajouté!');
      } else {
        toast.warning('Oups ! Stock épuisé');
      }


    } else {
      // let newAddItem = copyProducts.find(elt => elt.id == id ? elt : '');
      let newAddItem = products.find(elt => elt.id == id ? elt : '');
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
          }
        ]);

        // toast.success('Article ajouté!');

      } else {
        toast.warning('Oups ! Stock épuisé');
      }
    }
    console.log(cartField);
    setTotalCart(
      // cartField.reduce((total, elt) => { return total += elt.price; }, 0)
      cartField.reduce((total, elt) => { return total += elt.total_price; }, 0)
    );

    console.log('set de la quantité dans le menu de droite');
    // let proTemp = products;
    // let tmp_product = proTemp.find( elt => {
    //   elt.id == id ? elt.quantity -= 1 : ''
    // });

    // setProducts(tmp_product);

  }

  const deleteProdInCart = (e, id) => {
    e.preventDefault();

    // Restore quantity before delete
    let prod_delete = cartField.find(elt => elt.prod_id == id);
    restoreProductQuantity(id, prod_delete.quantity);

    let newListProd = cartField.filter(elt => elt.prod_id != id);
    setCartFiel(newListProd);

    setTotalCart(
      // newListProd.reduce((total, elt) => { return total += elt.price; }, 0)
      newListProd.reduce((total, elt) => { return total += elt.total_price; }, 0)
    );
  }

  const restoreProductQuantity = (id, add_quantity = 0) => {
    let oldProduct = copyProducts.find(elt => elt.id == id);

    // let tmp_products = [...products];
    // let tmp = tmp_products.find(elt => elt.id == id) ;

    // tmp.stock_quantity = oldProduct.stock_quantity;
    console.log(oldProduct);

    let new_prods = products.map(prod => {
      if (prod.id == id) {
        return { ...prod, stock_quantity: parseInt(prod.stock_quantity) + parseInt(add_quantity) }
      }
      return prod;
    })
    console.log('xx');
    console.log(new_prods);

    setProducts(new_prods);
  }

  const decrementProductQuantity = (id, index = null, remove_quantity = 1) => {
    console.log("Décrement --");
    console.log(index, id);
    let tmp_products = [...products];
    let tmp;
    if (index) {
      console.log('with index');
      tmp = { ...tmp_products[index] };
    } else {
      console.log('with id');
      tmp = tmp_products.find(elt => elt.id == id);
    }

    let quantity = parseInt(tmp.stock_quantity) - parseInt(remove_quantity);

    if (parseInt(tmp.stock_quantity) > 0 || quantity >= 0) {
      tmp.stock_quantity = quantity;

      console.log(tmp);
      tmp_products[index] = tmp;

      setProducts(tmp_products);
      // setCopyProducts(tmp_products);
    } else {

      // Lorsue le stock est épuisé
      return -5000000;
    }

  }

  const changeProductQuantity = (e, index) => {
    console.log(index);
    console.log(e);

    let val = e.target.validity.valid ? e.target.value : null;

    if (val == null) {
      toast.error('Entrez un nombre valide...');
      return -1;
    }

    let tmp_cartField = [...cartField];

    let tmp = { ...tmp_cartField[index] };
    let unitPrice = tmp.price / tmp.quantity;

    let current_prod = products.find(elt => elt.id == tmp.prod_id);

    // Modification manuel de la quantité d'un article dans le panier (via l'input)
    let debit_quantity = parseInt(val) - parseInt(tmp.quantity);
    if (
      (parseInt(current_prod.stock_quantity) + parseInt(tmp.quantity) - parseInt(val) >= 0)
      && decrementProductQuantity(tmp.prod_id, null, debit_quantity) != -5000000
    ) {
      tmp.quantity = val;
      // tmp.price = val * unitPrice;
      tmp.total_price = val * tmp.price;

      console.log(tmp);
      tmp_cartField[index] = tmp;

      setCartFiel(tmp_cartField);


    } else {
      toast.warning('Oups ! Stock insuffisant')
    }


  }

  const handleSubmit = () => {
    console.log(cartField);

    if (cartField.length == 0) {
      toast.warning('Panier vide');
      return;
    }

    setLoading(true);
    setDisableBtn(true);
    axios.post('/order', {
      cartField,
      customer,
      totalCart
    },
      {
        "Accept": 'application/json',
        "Content-Type": 'application/json',
        "'Access-Control-Allow-Origin'": '*'
      }).then((res) => {
        console.log(res);
        setCartFiel([]);
        setProducts(res.data.products);
        setCopyProducts(res.data.products);
        setCustomers(res.data.customers);
        setCategories(res.data.categories);
        setSetting(res.data.setting)
        setLoading(false);
        toast.success('Commande enregistrée !');
        setDisableBtn(false);
      }).catch((err) => {
        console.log(err);
        setLoading(false);
        toast.error('Echec !', false, 'error');
        setDisableBtn(false);
      });
  }

  const findProductWithBarcode = (code) => {
    let product = products.find(elt => elt.code == code);

    if (product) {
      selectProduct(product.id);

      // toast.success('Produit ajouté !');
    } else {
      // toast.error('Produit non existant !');
    }
  }

  const handleScanBarecode = (e) => {
    e.preventDefault();
    let code = e.target.value;
    e.target.value = '';

    findProductWithBarcode(code);
  }

  // reinitialiser les produits en cliquant sur le btn annuler
  const resetCartFiel = () => {
    // solution provisoire
    console.log(cartField);
    if (cartField.length > 0) {
      for (let k = 0; k < cartField.length; k++) {
        // Restore quantity before delete
        // let prod_delete = cartField.find(elt => elt.prod_id == id);
        restoreProductQuantity(cartField[k].prod_id, cartField[k].quantity);
        console.log(k);

      }
      setCartFiel([]);


      // // Restore quantity before delete
      // let prod_delete = cartField.find(elt => elt.prod_id == id);
      // restoreProductQuantity(id, prod_delete.quantity);

      // let newListProd = cartField.filter(elt => elt.prod_id != id);
      // setCartFiel(newListProd);

      // setTotalCart(
      //   // newListProd.reduce((total, elt) => { return total += elt.price; }, 0)
      //   newListProd.reduce((total, elt) => { return total += elt.total_price; }, 0)
      // );
    }
  }


  // Utilisation du lecteur de code barre pour inserer le produit
  useScanDetection({
    onComplete: findProductWithBarcode,
    minLength: 3
  });

  // Scanner le codebare en cliquant sur btn de scan de l'app
  const scanCode = () => {
    qrRf.current.openImageDialog();
  }

  const handleErrorFile = (err) => {
    console.log(err);
  }

  const handleScanFile = (res) => {
    if (res) {
      findProductWithBarcode(res);
    }
  }

  return (
    <>
      <div className="row">
        <div className="toast-container"><ToastContainer limit={3} /></div>
        <div className="col-md-6 col-lg-4 mb-2" style={{ border: '3px solid', borderColor: '#007bff' }}>
          <div className="row mb-2">
            <div className="col mt-2">

              <form >
                <input
                  type="search"
                  className="form-control form-control-border border-width-2"
                  placeholder="Barcode..."
                  autoFocus
                  onKeyDown={(e) => e.key === 'Enter' && handleScanBarecode(e)}
                />
              </form>
            </div>
            <div className="col mt-2">
              <button type="button" title='Scan code' onClick={() => scanCode()} className="btn btn-warning btn-sm"> <i className="fa fa-qrcode"></i> </button>
            </div>
            <div className="col mt-2">
              <select
                className="custom-select form-control-border border-width-2"
                onChange={(e) => setCustomer(e.target.value)}
              >
                <option value="">Client inconnu</option>
                {
                  customers?.map((customer, i) => (
                    <option value={customer.id} key={i}>{customer.name} </option>
                  ))
                }

              </select>
            </div>
          </div>
          <form action="">
            <div className="row mb-2">
              <div className="col">
                <table className="table table-striped">
                  <thead>
                    <tr>
                      <th>Product</th>
                      <th>Quantity</th>
                      <th className="text-right">Price</th>
                      <th className="text-right">Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    {
                      cartField.map((prod, i) => (
                        <tr key={i}>
                          <td hidden> <input type="text" value={prod.prod_id} /> </td>
                          <td>{prod.name.substring(0, 8)} </td>
                          <td>
                            <input
                              // onBlur={(e) => changeProductQuantity(e.target.value, i)} 
                              onChange={(e) => changeProductQuantity(e, i)}
                              type="text"
                              pattern="[0-9]*"
                              value={prod.quantity}
                              className='form-control' />
                            {prod.quantity}
                          </td>
                          <td> {prod.price}</td>
                          <td> {prod.total_price}</td>
                          <td><button className='btn btn-danger btn-sm' onClick={(e) => deleteProdInCart(e, prod.prod_id)}><span className='fas fa-times'></span></button></td>

                        </tr>
                      ))
                    }

                  </tbody>
                </table>


              </div>
            </div>

            <div className="row mb-2">
              <div className="col">

                {/* <QrReader
                ref={qrRf}
                delay={300}
                style={{width: '100%'}}
                onError={handleErrorFile}
                onScan={handleScanFile}
                legacyMode
              /> */}
              </div>
              <div className="col text-right">
                Total : <strong>{totalCart}</strong> {setting?.map((sett, key) => <i key={key}>{sett.devise} </i>)}
              </div>
            </div>
            <div className="row ">
              <div className="col">
                <button type="button" onClick={() => resetCartFiel()} className="btn btn-secondary btn-sm"> Cancel </button>
              </div>
              <div className="col">
                <button type="button" disabled={disableBtn} onClick={() => handleSubmit()} className="btn btn-success btn-sm"> Valider </button>
                {/* <button type="button" data-toggle="modal" data-target="#modal-payment" className="btn btn-primary btn-sm"> Payment </button> */}
              </div>
            </div>
          </form>

        </div>

        <div className="col-md-6 col-lg-8 " style={{ border: '3px solid', borderColor: '#007bff' }}>
          <Loader load={loading} />
          <div className="row mt-2">
            <div className="col-sm-6">
              <select className="custom-select form-control-border border-width-2"
                onChange={(e) => ParCategorie(e.target.value)}>
                <option value="0" selected >Toutes catégories</option>
                {
                  categories?.map((cat, i) => (
                    <option value={cat.id} key={i}>{cat.name} </option>
                  ))
                }
              </select>
            </div>
            <div className="col-sm-6">
              <input type="search" onChange={(e) => setSearchProduct(e.target.value)} className='form-control form-control-border border-width-2' placeholder='Rechercher un produit...' />
            </div>
          </div>

          <div className="row mt-2">
            {
              productFilter?.map((prod, i) => (
                <div className='col-2 ml-3'
                  key={i}
                  onClick={() => selectProduct(prod.id)}
                // onClick={() => selectProduct_new(prod)}
                >
                  <img src={`http://localhost:8000/storage/images/products/${prod.product_image}`} width={50} height={50} alt="" style={{ borderRadius: '10px' }} />
                  <h6>{prod.product_name} ({prod.stock_quantity})</h6>
                </div>
              ))
            }

          </div>
        </div>

      </div>
      {/* <PaymentModal totalAmount = {totalCart} amount_received = {totalCart} /> */}
    </>


  );
}

export default Pos;

if (document.getElementById('pos')) {
  const Index = ReactDOM.createRoot(document.getElementById("pos"));

  Index.render(
    <React.StrictMode>
      <Pos />
    </React.StrictMode>
  )
}
