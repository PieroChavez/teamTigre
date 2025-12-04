import Button from 'react-bootstrap/Button';
import Card from 'react-bootstrap/Card';

import portadaImg from '../assets/img/portada.jpg';

function Cards() {
  return (
   <>
    {/* Center the cards horizontally and tighten spacing */}
    <div style={{ display: 'flex', justifyContent: 'center', gap: '1.75rem', padding: '0 1rem', flexWrap: 'wrap', marginTop: '2rem', marginBottom: '1.5rem',}}>
      <Card style={{ width: '18rem' }}>
        <Card.Img variant="top" src={portadaImg} />
        <Card.Body>
          <Card.Title>Card Title</Card.Title>
          <Card.Text>
            Some quick example text to build on the card title and make up the
            bulk of the card's content.
          </Card.Text>
          <Button variant="primary">Go somewhere</Button>
        </Card.Body>
      </Card>

      <Card style={{ width: '18rem' }}>
        <Card.Img variant="top" src={portadaImg} />
        <Card.Body>
          <Card.Title>Card Title</Card.Title>
          <Card.Text>
            Some quick example text to build on the card title and make up the
            bulk of the card's content.
          </Card.Text>
          <Button variant="primary">Go somewhere</Button>
        </Card.Body>
      </Card> 

      <Card style={{ width: '18rem' }}>
        <Card.Img variant="top" src={portadaImg} />
        <Card.Body>
          <Card.Title>Card Title</Card.Title>
          <Card.Text>
            Some quick example text to build on the card title and make up the
            bulk of the card's content.
          </Card.Text>
          <Button variant="primary">Go somewhere</Button>
        </Card.Body>
      </Card>
    </div>
   
   </>

    
  );
}

export default Cards;