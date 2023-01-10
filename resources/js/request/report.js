import axios from "axios";

export async function getPrepareTarget({ programId, targetId }) {
    if (typeof programId === 'number' && typeof targetId === 'number') {
        try {
            const { data, status } = await axios.get(`/api/programs/target/${programId}/${targetId}`);
            if (status === 200) {
                return {
                    data: data,
                    error: false
                };
            } else {
                return {
                    error: true,
                    data: null
                };
            }
        } catch (error) {
            console.log(error);
            return {
                error: true,
                data: null
            };
        }
    } else {
        return {
            error: true,
            data: null
        };
    }
}

export async function postTargetReport(formData, programId, targetId) {
    try {
        const { data, status } = await axios.post(`/api/programs/target/${programId}/${targetId}`, formData);
        if (status === 200) {
            return {
                data: data,
                error: false
            };
        } else {
            return {
                error: true,
                data: null
            };
        }
    } catch (error) {
        console.log(error);
        return {
            error: true,
            data: null
        };
    }
}
