const express = require("express");
const router = express.Router();

const controller = require("../controllers/validationController");

router.post("/approve/:id", controller.approve);
router.post("/reject/:id", controller.reject);

module.exports = router;