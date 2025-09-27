import axios from "axios";

export const addSaleInvoice = async (data) => {
    try {
        const res = await axios.post(`/sale-invoice-store`, data, {
            headers: {
                "Content-Type": "multipart/form-data",
            },
        });

        return { success: true, data: res.data, status: res.status };
    } catch (error) {
        console.error("erreur add sale invoice", error);
        const status = error?.response?.status || 500;
        const message = error?.response?.data?.message || "Erreur inattendue";
        const errors = error?.response?.data?.errors || {};

        return { success: false, status, message, errors };
    }
};
export const updateSaleInvoice = async (data, id) => {
    try {
        const res = await axios.post(`/sale-invoice-update/${id}`, data, {
            headers: {
                "Content-Type": "multipart/form-data",
            },
        });

        return { success: true, data: res.data, status: res.status };
    } catch (error) {
        console.error("erreur add sale invoice", error);
        const status = error?.response?.status || 500;
        const message = error?.response?.data?.message || "Erreur inattendue";
        const errors = error?.response?.data?.errors || {};

        return { success: false, status, message, errors };
    }
};

export const getDataForInvoice = async () => {
    try {
        const res = await axios.get(`/sale-invoice-data`);

        return { success: true, data: res.data, status: res.status };
    } catch (error) {
        console.log("Erreur API:", error);

        const status = error?.response?.status || 500;
        const message = error?.response?.data?.message || "Erreur inattendue";
        const errors = error?.response?.data?.errors || {};

        return { success: false, status, message, errors };
    }
};
