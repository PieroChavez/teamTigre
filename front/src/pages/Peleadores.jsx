import { Box, Typography, Avatar, IconButton, Stack, Paper, Grid } from "@mui/material";
import { Instagram, Facebook, X } from "@mui/icons-material";
import NavBar from "../Components/Navigations/Navbar";

// Asegúrate de que la ruta de la imagen sea correcta
import portadaImg from '../assets/img/portada.jpg';

const baseFighters = [
  { name: "Carlos “El Jaguar” Medina", img: portadaImg, bio: "Peso pluma. Especialista en striking con 12 victorias por KO.", social: { ig: "https://instagram.com", fb: "https://facebook.com", x: "https://x.com" } },
  { name: "Luis “El Titán” Ramos", img: portadaImg, bio: "Peso welter. Dominio en lucha y jiu-jitsu. Récord de 15-2.", social: { ig: "https://instagram.com", fb: "https://facebook.com", x: "https://x.com" } },
  { name: "Eduardo “La Bestia” Paredes", img: portadaImg, bio: "Peso medio. Estilo agresivo, cardio elite, finalizador nato.", social: { ig: "https://instagram.com", fb: "https://facebook.com", x: "https://x.com" } },
  { name: "Jorge “El Samurai” Valdez", img: portadaImg, bio: "Peso ligero. Técnica impecable, 8 sumisiones profesionales.", social: { ig: "https://instagram.com", fb: "https://facebook.com", x: "https://x.com" } },



  { name: "Carlos “El Jaguar” Medina", img: portadaImg, bio: "Peso pluma. Especialista en striking con 12 victorias por KO.", social: { ig: "https://instagram.com", fb: "https://facebook.com", x: "https://x.com" } },
  { name: "Luis “El Titán” Ramos", img: portadaImg, bio: "Peso welter. Dominio en lucha y jiu-jitsu. Récord de 15-2.", social: { ig: "https://instagram.com", fb: "https://facebook.com", x: "https://x.com" } },
  { name: "Eduardo “La Bestia” Paredes", img: portadaImg, bio: "Peso medio. Estilo agresivo, cardio elite, finalizador nato.", social: { ig: "https://instagram.com", fb: "https://facebook.com", x: "https://x.com" } },
  { name: "Jorge “El Samurai” Valdez", img: portadaImg, bio: "Peso ligero. Técnica impecable, 8 sumisiones profesionales.", social: { ig: "https://instagram.com", fb: "https://facebook.com", x: "https://x.com" } },

  { name: "Adriana “La Leona” Soto", img: portadaImg, bio: "Peso mosca. Velocidad pura, 10 victorias por decisión.", social: { ig: "https://instagram.com", fb: "https://facebook.com", x: "https://x.com" } },
  { name: "Adriana “La Leona” Soto", img: portadaImg, bio: "Peso mosca. Velocidad pura, 10 victorias por decisión.", social: { ig: "https://instagram.com", fb: "https://facebook.com", x: "https://x.com" } },
  { name: "Adriana “La Leona” Soto", img: portadaImg, bio: "Peso mosca. Velocidad pura, 10 victorias por decisión.", social: { ig: "https://instagram.com", fb: "https://facebook.com", x: "https://x.com" } },
  { name: "Adriana “La Leona” Soto", img: portadaImg, bio: "Peso mosca. Velocidad pura, 10 victorias por decisión.", social: { ig: "https://instagram.com", fb: "https://facebook.com", x: "https://x.com" } },
  { name: "Adriana “La Leona” Soto", img: portadaImg, bio: "Peso mosca. Velocidad pura, 10 victorias por decisión.", social: { ig: "https://instagram.com", fb: "https://facebook.com", x: "https://x.com" } },

];

// Usaremos 5 peleadores para demostrar la columna incompleta (3 en la primera fila, 2 en la segunda)
const fighters = [
    ...baseFighters, 
    { name: "Adriana “La Leona” Soto", img: portadaImg, bio: "Peso mosca. Velocidad pura, 10 victorias por decisión.", social: { ig: "https://instagram.com", fb: "https://facebook.com", x: "https://x.com" } },
]; 

export default function FightersList() {
  return (
    <>
    <NavBar/>
    <Box
      sx={{
        // Aumentamos el espacio máximo para garantizar el espacio
        maxWidth: "1300px", 
        margin: "5rem auto",
        // Eliminamos el padding lateral para ganar más espacio horizontal
        // padding: "0 1rem", 
      }}
    >
      <Typography 
        variant="h3"
        mb={5} 
        fontWeight={800} 
        textAlign="center"
        sx={{ textTransform: 'uppercase', fontStyle: 'italic', color: '#d32f2f' }}
      >
        Cartelera Oficial
      </Typography>

      {/* Grid con spacing mínimo */}
      <Grid container spacing={1} justifyContent="center">
        {fighters.map((fighter, index) => (
          <Grid
            item
            xs={12}      // Móvil: 1 columna
            sm={4}      // <--- CLAVE: 3 columnas forzadas para Tablet y PC (12 / 4 = 3)
            md={4}      // PC: 3 columnas
            key={index}
            sx={{ display: 'flex', justifyContent: 'center' }}
          >
            <Paper
              elevation={6}
              sx={{
                display: "flex",
                flexDirection: "column",
                justifyContent: "center",
                alignItems: "center",
                p: 2, // Padding reducido al mínimo (2)
                width: "100%",
                borderRadius: "4px", 
                textAlign: "center",
                backgroundColor: "#121212",
                color: "#fff",
                transition: "transform 0.3s ease",
                "&:hover": {
                    transform: "translateY(-5px)",
                    boxShadow: "0 10px 20px rgba(0,0,0,0.5)"
                }
              }}
            >
              <Avatar
                src={fighter.img}
                alt={fighter.name}
                sx={{ 
                    width: { xs: 120, md: 140 }, 
                    height: { xs: 120, md: 140 }, 
                    marginBottom: 2, 
                    border: '4px solid #d32f2f',
                    boxShadow: '0 0 15px rgba(211, 47, 47, 0.5)'
                }} 
              />

              <Box flexGrow={1}>
                <Typography 
                    variant="h6"
                    fontWeight={800} 
                    textTransform="uppercase" 
                    lineHeight={1.2}
                    sx={{ mb: 1, color: '#fdd835' }}
                >
                  {fighter.name}
                </Typography>

                <Typography variant="body2" color="grey.400" mt={1} mb={2} px={1}>
                  {fighter.bio}
                </Typography>

                <Stack direction="row" spacing={1} justifyContent="center">
                  <IconButton sx={{ color: '#fff' }} href={fighter.social.ig} target="_blank">
                    <Instagram fontSize="medium" />
                  </IconButton>
                  <IconButton sx={{ color: '#fff' }} href={fighter.social.fb} target="_blank">
                    <Facebook fontSize="medium" />
                  </IconButton>
                  <IconButton sx={{ color: '#fff' }} href={fighter.social.x} target="_blank">
                    <X fontSize="medium" />
                  </IconButton>
                </Stack>
              </Box>
            </Paper>
          </Grid>
        ))}
      </Grid>
    </Box>
    </>
  );
}