
import Portada from "../Components/portada"
import Cards from "../Components/carusel"
import NavBar from "../Components/Navigations/Navbar"
import Footer from "../Components/Footer"



function IndexHome() {
  return (
    <div>
       <NavBar/>
        <Portada/>
        <Cards/>
        <Footer/>
     
      
    </div>
  )
}

export default IndexHome
