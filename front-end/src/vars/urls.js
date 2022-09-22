import {CLIENT_ID} from "./credentials";

const GET_CODE='https://github.com/login/oauth/authorize?client_id='+CLIENT_ID;
const GET_ACCESS_TOKEN='https://github.com/login/oauth/access_token';

const HOST_URI='http://localhost:8080';
const REDIRECT_URI=HOST_URI+'/getScores';

export { GET_CODE, HOST_URI, REDIRECT_URI, GET_ACCESS_TOKEN };




