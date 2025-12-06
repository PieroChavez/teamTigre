// server.js
import dotenv from "dotenv";
dotenv.config();

import app from "./src/app.js";
import { connectDB } from "./src/db.js";

const PORT = process.env.PORT || 4000;

const startServer = async () => {
  try {
    console.log("🔌 Conectando a la base de datos...");
    await connectDB();
    console.log("✅ Base de datos conectada correctamente.");

    app.listen(PORT, () => {
      console.log(`🚀 Servidor corriendo en http://localhost:${PORT}`);
    });
  } catch (error) {
    console.error("❌ Error al iniciar el servidor:", error);
    process.exit(1);
  }
};

startServer();
