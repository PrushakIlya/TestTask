import { useLocation } from 'react-router';
import { useEffect } from "react";
import { getAccessToken } from "./api/post";
import {GET_ACCESS_TOKEN, REDIRECT_URI} from "./vars/urls";
import {CLIENT_ID, CLIENT_SECRET} from "./vars/credentials";


const GetCode = () => {
  const search = useLocation().search;
  const code = new URLSearchParams(search).get('code');
  const data ={
    client_id : CLIENT_ID,
    client_secret : CLIENT_SECRET,
    'code' : code,
  }

  useEffect(() => {
    getAccessToken('http://localhost:8080/api/v1/index', data)
  }, []);
}

export default GetCode;
