import axios from "axios";
// import { interceptorRequest, interceptorReponse } from "./interceptor";

const departmentApi = axios.create({
    baseURL: import.meta.env.VITE_BACKEND_URL + "/api/department",
});

// departmentApi.interceptors.request.use(interceptorRequest);
// departmentApi.interceptors.response.reject(interceptorReponse);

export default departmentApi;
