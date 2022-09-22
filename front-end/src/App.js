import { Routes, Route } from 'react-router-dom';
import GetCode from "./GetCode";
import Main from "./components/Main";
import GetScores from "./components/GetScores";

function App() {
  return (
    <>
      <Routes>
        <Route path='/' element={<Main />} />
        <Route path='/getCode' element={<GetCode />} />
        <Route path='/getScores' element={<GetScores />} />
      </Routes>
    </>
  );
}

export default App;
