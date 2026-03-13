const express = require("express");
const cors = require("cors");

const requestRoutes = require("./routes/requestRoutes");
const validationRoutes = require("./routes/validationRoutes");

const app = express();

app.use(cors());
app.use(express.json());
app.use(express.static("public"));

app.use("/requests", requestRoutes);
app.use("/validation", validationRoutes);

const PORT = 3000;

app.listen(PORT, () => {
  console.log("Server running on port " + PORT);
});