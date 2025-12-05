import 'bootstrap/dist/css/bootstrap.min.css';
import { BrowserRouter, Routes, Route } from "react-router-dom";

import Login from "./Auth/Login";
import Register from "./Auth/Register";

import DashboardAdm from './Admin/Adm'

import UserHome from './User/Home';
import IndexHome from './pages/IndexHome';
import FightersLis from './pages/Peleadores';
import NavBar from './Components/Navigations/Navbar';

function App() {

  return (
    <>
      <BrowserRouter>          
        <NavBar/>
        <Routes>        
          <Route path="/" element={<IndexHome />} />
          <Route path='/peleadores' element={<FightersLis/>}/>


          <Route path="/login" element={<Login />} />
          <Route path="/register" element={<Register />} />
          <Route path="/DashboardAdm" element={<DashboardAdm />} />
          <Route path='/Home' element={<UserHome/>} />
        </Routes>

       
      </BrowserRouter>
    </>
  );
}

export default App;
