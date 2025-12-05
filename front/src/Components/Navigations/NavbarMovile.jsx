import React from "react";
import { useNavigate } from "react-router-dom";
import {
  BottomNavigation,
  BottomNavigationAction,
  Paper,
  Box,
  Avatar,
} from "@mui/material";

import HomeIcon from "@mui/icons-material/Home";
import ShoppingBagIcon from "@mui/icons-material/ShoppingBag";
import WhatsAppIcon from "@mui/icons-material/WhatsApp";
import PeopleIcon from "@mui/icons-material/People";
import AccountCircleIcon from "@mui/icons-material/AccountCircle";

const MobileNavBar = () => {
  const navigate = useNavigate();
  const [value, setValue] = React.useState(0);

  // Usuario de ejemplo
  const user = {
    name: "Usuario Demo",
    picture:
      "https://i.pravatar.cc/300?img=13", // avatar random profesional
  };

  const handleChange = (event, newValue) => {
    setValue(newValue);

    switch (newValue) {
      case 0:
        navigate("/home");
        break;
      case 1:
        navigate("/store");
        break;
      case 2:
        window.open("https://wa.me/51945848943", "_blank");
        break;
      case 3:
        navigate("/nosotros");
        break;
      case 4:
        navigate("/profile");
        break;
      default:
        break;
    }
  };

  const iconWrapperStyle = (index) => ({
    width: 40,
    height: 40,
    display: "flex",
    alignItems: "center",
    justifyContent: "center",
    transition: "transform 0.2s ease, box-shadow 0.2s ease",
    transform: value === index ? "scale(1.2)" : "scale(1)",
    borderRadius: "50%",
  });

  const getIconColor = (index) =>
    value === index ? "primary.main" : "text.disabled";

  return (
    <Paper
      sx={{
        position: "fixed",
        bottom: 0,
        left: 0,
        right: 0,
        zIndex: 1000,
      }}
      elevation={8}
    >
      <BottomNavigation value={value} onChange={handleChange} showLabels>
        <BottomNavigationAction
          label="Inicio"
          icon={
            <Box sx={iconWrapperStyle(0)}>
              <HomeIcon sx={{ color: getIconColor(0) }} />
            </Box>
          }
        />

        <BottomNavigationAction
          label="Tienda"
          icon={
            <Box sx={iconWrapperStyle(1)}>
              <ShoppingBagIcon sx={{ color: getIconColor(1) }} />
            </Box>
          }
        />

        <BottomNavigationAction
          label="Contactar"
          icon={
            <Box sx={iconWrapperStyle(2)}>
              <WhatsAppIcon sx={{ color: getIconColor(2) }} />
            </Box>
          }
        />

        <BottomNavigationAction
          label="Aliados"
          icon={
            <Box sx={iconWrapperStyle(3)}>
              <PeopleIcon sx={{ color: getIconColor(3) }} />
            </Box>
          }
        />

        <BottomNavigationAction
          label="Perfil"
          icon={
            <Box sx={iconWrapperStyle(4)}>
              {user.picture ? (
                <Avatar
                  src={user.picture}
                  alt={user.name}
                  sx={{
                    width: 24,
                    height: 24,
                    border:
                      value === 4
                        ? "2px solid #1976d2"
                        : "2px solid transparent",
                  }}
                />
              ) : (
                <AccountCircleIcon sx={{ color: getIconColor(4) }} />
              )}
            </Box>
          }
        />
      </BottomNavigation>
    </Paper>
  );
};

export default MobileNavBar;
