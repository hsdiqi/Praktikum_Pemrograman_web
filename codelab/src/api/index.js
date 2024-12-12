import axios from "axios";

const Api = axios.create({
  //samakan dengan url api Laravel modul 5
  baseURL: "http://127.0.0.1:8000",
});

export default Api;
