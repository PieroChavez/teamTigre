import Button from 'react-bootstrap/Button';
import Container from 'react-bootstrap/Container';
import Form from 'react-bootstrap/Form';
import Nav from 'react-bootstrap/Nav';
import Navbar from 'react-bootstrap/Navbar';
import NavDropdown from 'react-bootstrap/NavDropdown';

import logo from '../assets/logo.png';

function NavBar() {
  return (
    <Navbar
      expand="lg"
      fixed="top"
      bg="light"
      className="shadow-sm px-3"
      style={{
        borderRadius: "50px",
        width: "92%",
        maxWidth: "1100px",
        left: "50%",
        transform: "translateX(-50%)",
        top: "10px",
        zIndex: "1050",
      }}
    >
      <Container fluid>

        {/* BRAND / LOGO */}
        <Navbar.Brand href="/" className="fw-bold d-flex align-items-center">
          <img
            src={logo}
            alt="logo"
            height="36"
            className="me-2"
            style={{ objectFit: "contain" }}
          />
          EL TIGRE
        </Navbar.Brand>

        <Navbar.Toggle aria-controls="nav" />
        <Navbar.Collapse id="nav">

          {/* LINKS */}
          <Nav className="me-auto my-2 my-lg-0" navbarScroll>
            <Nav.Link href="/">HOME</Nav.Link>
            <Nav.Link href="/peleadores">PELEADORES</Nav.Link>

            <NavDropdown title="EVENTOS" id="basic-nav-dropdown">
              <NavDropdown.Item href="/eventos/proximos">
                Próximos
              </NavDropdown.Item>
              <NavDropdown.Item href="/eventos/pasados">
                Pasados
              </NavDropdown.Item>
              <NavDropdown.Divider />
              <NavDropdown.Item href="/boletos">
                Boletos
              </NavDropdown.Item>
            </NavDropdown>
          </Nav>

          {/* SEARCH INPUT */}
          <div className="d-flex align-items-center me-3 position-relative">
            <i
              className="bi bi-search position-absolute"
              style={{ left: 10, top: "50%", transform: "translateY(-50%)" }}
            ></i>

            <Form.Control
              type="search"
              placeholder="Buscar"
              className="ps-8"
              style={{
                borderRadius: "20px",
                paddingLeft: "34px",
                height: "36px",
              }}
            />
          </div>

          {/* AVATAR LOGIN */}
          <Nav.Link href="/login" className="d-flex align-items-center">
            <div
              className="rounded-circle bg-secondary d-flex justify-content-center align-items-center"
              style={{ width: "36px", height: "36px" }}
            >
              <i className="bi bi-person-fill text-white"></i>
            </div>
          </Nav.Link>

        </Navbar.Collapse>
      </Container>
    </Navbar>
  );
}

export default NavBar;
