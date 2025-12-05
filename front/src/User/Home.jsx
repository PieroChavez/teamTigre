import { Box, useMediaQuery } from "@mui/material";
import MobileNavBar from "../Components/Navigations/NavbarMovile"

const PlaceholderBox = ({ title, height = "200px" }) => (
  <Box
    bgcolor="#ffffff"
    borderRadius="12px"
    boxShadow="0 2px 6px rgba(0,0,0,0.1)"
    p={2}
    mb={2}
    height={height}
    display="flex"
    justifyContent="center"
    alignItems="center"
    fontSize="1.1rem"
    fontWeight="600"
    color="#555"
  >
    {title}
  </Box>
);

const UserHome = () => {
  const isNonMobileScreens = useMediaQuery("(min-width:1000px)");

  return (
   <>
   
    {/* Replace fixed height with minHeight so the gray background grows with content */}
    <Box minHeight="100vh" display="flex" flexDirection="column" bgcolor="#f0f0f0">
      {/* CONTENEDOR GENERAL */}
      <Box
        flexGrow={1}
        display={isNonMobileScreens ? "flex" : "block"}
        gap="0.5rem"
        justifyContent="space-between"
        padding={isNonMobileScreens ? "4.5rem 1%" : "5rem 0.5rem"}
      >
        {/* COLUMNA IZQUIERDA */}
        <Box
          flexBasis={isNonMobileScreens ? "22%" : "100%"}
          mb={isNonMobileScreens ? 0 : 2}
          mt={isNonMobileScreens ? "0.5rem" : 0} // add slight offset only on PC
        >
          <PlaceholderBox title="UserWidget" height="250px" />
          <PlaceholderBox title="Logos" height="150px" />
        </Box>

        {/* COLUMNA CENTRAL */}
        <Box
          flexBasis={isNonMobileScreens ? "56%" : "100%"}
          sx={{
            px: isNonMobileScreens ? "2rem" : "1rem",
            py: "1rem",
            overflowY: isNonMobileScreens ? "auto" : "visible",
            maxHeight: isNonMobileScreens ? "calc(100vh - 5rem)" : "none",
            mx: "auto",
          }}
        >
          <PlaceholderBox title="MyPostWidget" height="150px" />
          <PlaceholderBox title="Stories" height="120px" />
          <PlaceholderBox title="PostsWidget (Feed)" height="800px" />
        </Box>

        {/* COLUMNA DERECHA – solo PC */}
        {isNonMobileScreens && (
          <Box flexBasis="22%" mt="0.5rem"> {/* add slight offset only on PC */}
            <PlaceholderBox title="AdvertWidget" height="180px" />
            <PlaceholderBox title="FriendListWidget" height="350px" />
          </Box>
        )}
      </Box>

      {/* NAVBAR MOBILE */}
      {!isNonMobileScreens && (
        <Box>
          <MobileNavBar/>
        
        </Box>
      )}
    </Box>
   </>
  );
};

export default UserHome;
