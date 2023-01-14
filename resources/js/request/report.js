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

export async function deleteTargetReport({ programId, targetId, fileId }, payload) {
    try {
        const { data, status } = await axios.delete(`/api/programs/target/${programId}/${targetId}/${fileId}`, {
            ...payload
        });

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

export async function updateTargetReport({ programId, targetId, fileId }, formData) {
    try {
        formData.append('_method', 'PUT');
        const { data, status } = await axios.post(`/api/programs/target/${programId}/${targetId}/${fileId}`, formData);

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
