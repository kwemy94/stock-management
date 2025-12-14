import axios from "axios";

export const addBuyCmd = async (data) => {
    try {
        const res = await axios.post(`/dashboard/buy-command-order`, data, {
            headers: {
                "Content-Type": "multipart/form-data",
            },
        });

        return { success: true, data: res.data, status: res.status };
    } catch (error) {
        console.error("erreur add Buy cmd", error);
        const status = error?.response?.status || 500;
        const message = error?.response?.data?.message || "Erreur inattendue buy";
        const errors = error?.response?.data?.errors || {};

        return { success: false, status, message, errors };
    }
};
export const updateBuyCommand = async (data, id) => {
    try {
        const res = await axios.put(`/dashboard/buy-command-order/${id}`, data);

        return { success: true, data: res.data, status: res.status };
    } catch (error) {
        console.error("erreur update buy command", error);
        const status = error?.response?.status || 500;
        const message = error?.response?.data?.message || "Erreur inattendue";
        const errors = error?.response?.data?.errors || {};

        return { success: false, status, message, errors };
    }
};

export const getDataForCmd = async () => {
    try {
        const res = await axios.get(`/dashboard/buy-command-create-data`);

        return { success: true, data: res.data, status: res.status };
    } catch (error) {
        console.log("Erreur API:", error);

        const status = error?.response?.status || 500;
        const message = error?.response?.data?.message || "Erreur inattendue";
        const errors = error?.response?.data?.errors || {};

        return { success: false, status, message, errors };
    }
};

export const addBuyReceipt = async (data) => {
    try {
        const res = await axios.post(`/dashboard/buy-reception`, data);

        return { success: true, data: res.data, status: res.status };
    } catch (error) {
        console.error("erreur add Buy receipt", error);
        const status = error?.response?.status || 500;
        const message = error?.response?.data?.message || "Erreur inattendue buy receipt";
        const errors = error?.response?.data?.errors || {};

        return { success: false, status, message, errors };
    }
};
