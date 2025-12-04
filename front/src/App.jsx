import 'bootstrap/dist/css/bootstrap.min.css';
import { BrowserRouter, Routes, Route } from "react-router-dom";

import Login from "./Auth/Login";
import Register from "./Auth/Register";
//import NavBar from './Components/Navbar';
import Footer from './Components/Footer';
import DashboardAdm from './Admin/Adm'

import UserHome from './User/Home';
import IndexHome from './pages/IndexHome';
import FightersLis from './pages/Peleadores';

function App() {

  return (
    <>
      <BrowserRouter>   
        

        <Routes>        
          <Route path="/" element={<IndexHome />} />
          <Route path='/peleadores' element={<FightersLis/>}/>


          <Route path="/login" element={<Login />} />
          <Route path="/register" element={<Register />} />
          <Route path="/DashboardAdm" element={<DashboardAdm />} />
          <Route path='/Home' element={<UserHome/>} />
        </Routes>

        <Footer/>
      </BrowserRouter>
    </>
  );
}

export default App;
