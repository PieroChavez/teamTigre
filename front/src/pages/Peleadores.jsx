import { Box, Typography, Avatar, IconButton, Stack, Paper, Grid } from "@mui/material";
import { Instagram, Facebook, X } from "@mui/icons-material";
import NavBar from "../Components/Navbar";

import portadaImg from '../assets/img/portada.jpg';

const fighters = [
  {
    name: "Carlos “El Jaguar” Medina",
    img: portadaImg,
    bio: "Peso pluma. Especialista en striking con 12 victorias por KO.",
    social: {
      ig: "https://instagram.com",
      fb: "https://facebook.com",
      x: "https://x.com",
    },
  },
  {
    name: "Luis “El Titán” Ramos",
    img: portadaImg,
    bio: "Peso welter. Dominio en lucha y jiu-jitsu. Récord de 15-2.",
    social: {
      ig: "https://instagram.com",
      fb: "https://facebook.com",
      x: "https://x.com",
    },
  },
  {
    name: "Eduardo “La Bestia” Paredes",
    img: portadaImg,
    bio: "Peso medio. Estilo agresivo, cardio elite, finalizador nato.",
    social: {
      ig: "https://instagram.com",
      fb: "https://facebook.com",
      x: "https://x.com",
    },
  },
  {
    name: "Jorge “El Samurai” Valdez",
    img: portadaImg,
    bio: "Peso ligero. Técnica impecable, 8 sumisiones profesionales.",
    social: {
      ig: "https://instagram.com",
      fb: "https://facebook.com",
      x: "https://x.com",
    },
  },
];

export default function FightersList() {
  return (
    <>
    <NavBar/>
    <Box
      sx={{
        maxWidth: "1100px",
        margin: "4.5rem auto",
        padding: "1rem",
      }}
    >
      <Typography variant="h4" mb={3} fontWeight={700}>
        Peleadores Oficiales
      </Typography>

      <Grid container spacing={2}>
        {fighters.map((fighter, index) => (
          <Grid
            item
            xs={12}      // móvil: 1 columna
            sm={6}       // PC/tablet: 2 columnas
            key={index}
          >
            <Paper
              sx={{
                display: "flex",
                gap: 2,
                p: 2,
                borderRadius: "12px",
                alignItems: "center",
                height: "100%",
              }}
            >
              <Avatar
                src={fighter.img}
                alt={fighter.name}
                sx={{ width: 80, height: 80 }}
              />

              <Box flexGrow={1}>
                <Typography variant="h5" fontWeight={600}>
                  {fighter.name}
                </Typography>

                <Typography variant="body2" color="text.secondary">
                  {fighter.bio}
                </Typography>

                <Stack direction="row" spacing={1} mt={1}>
                  <IconButton color="inherit" href={fighter.social.ig} target="_blank">
                    <Instagram />
                  </IconButton>
                  <IconButton color="inherit" href={fighter.social.fb} target="_blank">
                    <Facebook />
                  </IconButton>
                  <IconButton color="inherit" href={fighter.social.x} target="_blank">
                    <X />
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
