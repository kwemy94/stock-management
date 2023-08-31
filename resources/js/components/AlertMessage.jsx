import Swal from "sweetalert2";



const AlertMessage = (title, confirmBtn = false, icon = 'success', position='top-end') => {

    return(
        Swal.fire({
            position: position,
            icon: icon,
            title: title,
            showConfirmButton: confirmBtn,
            timer: 1500
          })
    );
}

export default AlertMessage;