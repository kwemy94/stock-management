import React, { useEffect, useState } from 'react';
import ReactDOM from 'react-dom/client';
import axios from 'axios';
import Loader from './Loader';

function Pos() {

  const [products, setProducts] = useState();

  // Copie des prod pour afficher par catégorie
  const [copyProducts, setCopyProducts] = useState();
  const [customers, setCustomers] = useState();
  const [searchProduct, setSearchProduct] = useState('');
  const [scanBarecode, setScanBarecode] = useState('');
  const [categories, setCategories] = useState([]);
  const [setting, setSetting] = useState();
  const [loading, setLoading] = useState(true);
  const [totalCart, setTotalCart] = useState(0);

  const [cartField, setCartFiel] = useState([
    // { prod_id: '', name: '', quantity: '', price: '' }
  ]);

  useEffect(() => {
    loadData();
  }, []);

  useEffect(() => {
    console.log('total');
    setTotalCart(
      cartField.reduce((total, elt) => { return total += elt.price; }, 0)
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
      cartField.find((elt) => {
        elt.prod_id == id
          ? (elt.price += (foundProd.price / foundProd.quantity), elt.quantity += 1)
          : '';

      });
    } else {
      let newAddItem = copyProducts.find(elt => elt.id == id ? elt : '');
      console.log(newAddItem);
      if (newAddItem.stock_quantity > 0) {
        setCartFiel([
          ...cartField,
          {
            prod_id: newAddItem.id,
            name: newAddItem.product_name,
            quantity: 1,
            price: newAddItem.sale_price
          }
        ]);
      } else {
        alert('Stock épuisé');
      }
    }
    console.log(cartField);
    setTotalCart(
      cartField.reduce((total, elt) => { return total += elt.price; }, 0)
    );

  }

  const deleteProdInCart = (id) => {
    let newListProd = cartField.filter(elt => elt.prod_id != id);
    setCartFiel(newListProd);

    setTotalCart(
      newListProd.reduce((total, elt) => { return total += elt.price; }, 0)
    );
  }

  return (
    <div className="row">
      <div className="col-md-6 col-lg-4 mb-2" style={{ border: '3px solid', borderColor: '#007bff' }}>
        <div className="row mb-2">
          <div className="col mt-2">

            <form >
              <input
                type="search"
                className="form-control form-control-border border-width-2"
                placeholder="Scan Barcode..."
                autoFocus
                onChange={(e) => setScanBarecode(e.target.value)}
              />
            </form>
          </div>
          <div className="col mt-2">
            <select
              className="custom-select form-control-border border-width-2"
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
                  </tr>
                </thead>
                <tbody>
                  {
                    cartField.map((prod, i) => (
                      <tr key={i}>
                        <td hidden> <input type="text" value={prod.prod_id} /> </td>
                        <td>{prod.name} </td>
                        <td> <input type="text" className='form-control' style={{ height: '25px', width: '35px' }} value={prod.quantity} /></td>
                        <td> <input type="text" className='form-control' style={{ height: '25px', width: '100px' }} readOnly value={prod.price} /></td>
                        <u className='btn btn-danger btn-sm' onClick={() => deleteProdInCart(prod.prod_id)}><span className='fas fa-times'></span></u>
                      </tr>
                    ))
                  }

                </tbody>
              </table>


            </div>
          </div>
          <div className="row">
            <div className="col">Total:</div>
            <div className="col text-right">
              {totalCart} {setting?.map(sett => <>{sett.devise} </>)}
            </div>
          </div>
          <div className="row ">
            <div className="col">
              <button type="button" className="btn btn-secondary btn-sm"> Cancel </button>
            </div>
            <div className="col">
              <button type="button" className="btn btn-success btn-sm"> Valider </button>
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
              <div className='col-2 ml-3' key={i} onClick={() => selectProduct(prod.id)}>
                <img src={`http://localhost:8000/storage/images/products/${prod.product_image}`} width={50} height={50} alt="" style={{ borderRadius: '10px' }} />
                <h6>{prod.product_name} ({prod.stock_quantity})</h6>
              </div>
            ))
          }

        </div>



        {/* <div className="timeline">
          <div>

            <div className="timeline-item">
              <div className="timeline-header m-2">

              </div>
              
            </div>
          </div>

        </div> */}
      </div>
    </div>
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
