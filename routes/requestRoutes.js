const express = require("express");
const router = express.Router();

const controller = require("../controllers/requestController");

router.get("/", controller.getRequests);
router.post("/create", controller.createRequest);

module.exports = router;