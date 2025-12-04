import { Box, useMediaQuery } from "@mui/material";

import NavBar from "../Components/Navbar";

const UserHome = () => {
  const isNonMobileScreens = useMediaQuery("(min-width:1000px)");

  // (Se eliminaron estado de Auth0 y condicionamientos de carga/autenticación)

  return (
    <>
    <NavBar/>
    
    <Box height="100vh" display="flex" flexDirection="column">
      <Box
        flexGrow={1}
        display={isNonMobileScreens ? "flex" : "block"}
        gap="0.5rem"
        justifyContent="space-between"
        padding={isNonMobileScreens ? "4.5rem 1%" : "4rem 0.5rem"}
      >
        {/* Columna izquierda */}
        <Box
          flexBasis={isNonMobileScreens ? "22%" : "100%"}
          mb={isNonMobileScreens ? 0 : 2}
          sx={{
            bgcolor: "grey.100",
            borderRadius: 2,
            border: "1px solid",
            borderColor: "divider",
            p: 2,
          }}
        >
          Columna izquierda
        </Box>

        {/* Columna central scrollable */}
        <Box
          flexBasis={isNonMobileScreens ? "56%" : "100%"}
          sx={{
            px: isNonMobileScreens ? "2rem" : "1rem",
            py: "1rem",
            overflowY: isNonMobileScreens ? "auto" : "visible",
            maxHeight: isNonMobileScreens ? "calc(100vh - 5rem)" : "none",
            mx: "auto",
            bgcolor: "grey.100",
            borderRadius: 2,
            border: "1px solid",
            borderColor: "divider",
            minHeight: "60vh",
          }}
        >
          Contenido central
        </Box>

        {/* Columna derecha */}
        {isNonMobileScreens && (
          <Box
            flexBasis="22%"
            sx={{
              bgcolor: "grey.100",
              borderRadius: 2,
              border: "1px solid",
              borderColor: "divider",
              p: 2,
            }}
          >
            Columna derecha
          </Box>
        )}
      </Box>

      {/* Navbar móvil solo en pantallas pequeñas */}
      {!isNonMobileScreens && (
        <Box
          position="fixed"
          bottom={0}
          left={0}
          right={0}
          height="3.5rem"
          sx={{
            bgcolor: "primary.main",
            color: "primary.contrastText",
            display: "flex",
            alignItems: "center",
            justifyContent: "center",
          }}
        >
          Navbar móvil
        </Box>
      )}
    </Box>
    </>
  );
};

export default UserHome;
