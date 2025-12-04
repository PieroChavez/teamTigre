import portadaImg from '../assets/img/portada.jpg';
import Container from 'react-bootstrap/Container';
import Row from 'react-bootstrap/Row';
import Col from 'react-bootstrap/Col';

import Badge from 'react-bootstrap/Badge';
import ListGroup from 'react-bootstrap/ListGroup';

function Portada() {
  return (
    <>
      <div style={{ height: "40px" }} aria-hidden="true"></div>

      {/* Make container fixed-width on md+ and cap desktop width */}
      <Container fluid="md" className="mt-0 mt-lg-5 mx-auto" style={{ maxWidth: "1200px" }}>
        <Row className="g-4 align-items-stretch">
          {/* Increase image column width on desktop from 6 to 7 */}
          <Col xs={12} lg={7}>
            <section className="position-relative w-100">
              <img
                src={portadaImg}
                alt="Imagen de portada"
                className="w-100 shadow-sm"
                style={{
                  height: "450px",
                  objectFit: "cover",
                  objectPosition: "center"
                }}
              />
            </section>
          </Col>

          {/* Reduce list column width on desktop from 6 to 5 */}
          <Col xs={12} lg={5}>
          <div> <h2>TOP HISTORY</h2></div>
            <ListGroup as="ol" numbered>
              <ListGroup.Item
                as="li"
                className="d-flex justify-content-between align-items-start"
              >
               
                <div className="ms-2 me-auto">
                  <div className="fw-bold">Subheading</div>
                  Cras justo odio
                </div>
                <Badge bg="primary" pill>
                  14
                </Badge>
              </ListGroup.Item>
              <ListGroup.Item
                as="li"
                className="d-flex justify-content-between align-items-start"
              >
                <div className="ms-2 me-auto">
                  <div className="fw-bold">Subheading</div>
                  Cras justo odio
                </div>
                <Badge bg="primary" pill>
                  14
                </Badge>
              </ListGroup.Item>
              <ListGroup.Item
                as="li"
                className="d-flex justify-content-between align-items-start"
              >
                <div className="ms-2 me-auto">
                  <div className="fw-bold">Subheading</div>
                  Cras justo odio
                </div>
                <Badge bg="primary" pill>
                  14
                </Badge>
              </ListGroup.Item>
            </ListGroup>
          </Col>
        </Row>
      </Container>

      
</>
  );
}

export default Portada;
