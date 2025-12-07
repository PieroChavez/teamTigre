import Hero from "../models/heroI.model.js";

// GET ALL
export const getHero = async (req, res) => {
  try {
    const data = await Hero.findAll();
    res.json(data);
  } catch (error) {
    res.status(500).json({ error: "Error al obtener los datos del hero" });
  }
};

// CREATE
export const createHero = async (req, res) => {
  try {
    const { subtitle, title, description } = req.body;

    if (!req.file) {
      return res.status(400).json({ error: "Debe subir una imagen" });
    }

    const image = req.file.filename;

    const hero = await Hero.create({
      subtitle,
      title,
      description,
      image,
    });

    res.json(hero);
  } catch (error) {
    res.status(500).json({ error: "Error al crear el hero" });
  }
};

// UPDATE
export const updateHero = async (req, res) => {
  try {
    const { id } = req.params;
    const hero = await Hero.findByPk(id);

    if (!hero) return res.status(404).json({ error: "Hero no encontrado" });

    const { subtitle, title, description } = req.body;

    let image = hero.image;
    if (req.file) {
      image = req.file.filename;
    }

    await hero.update({
      subtitle,
      title,
      description,
      image,
    });

    res.json({ message: "Hero actualizado", hero });
  } catch (error) {
    res.status(500).json({ error: "Error al actualizar el hero" });
  }
};

// DELETE
export const deleteHero = async (req, res) => {
  try {
    const { id } = req.params;

    const hero = await Hero.findByPk(id);
    if (!hero) return res.status(404).json({ error: "Hero no encontrado" });

    await hero.destroy();

    res.json({ message: "Hero eliminado" });
  } catch (error) {
    res.status(500).json({ error: "Error al eliminar el hero" });
  }
};
