const express = require("express");
const mysql = require("mysql");
const cors = require("cors");


const app = express();
const PORT = 3001;

// Configurar CORS para permitir requisições do React
app.use(cors());

const db = mysql.createConnection({
	host: "localhost",
	user: "carlos",
	password: "1234",
	database: "CursoDB"
});


db.connect((err) => {
  if (err) {
    console.error("Erro ao conectar ao banco de dados:", err);
    return;
  }
  console.log("Conectado ao banco de dados!");
});


// Endpoint para buscar o curso
// Endpoint para buscar um curso por ID
app.get("/api/curso/:id", async (req, res) => {
  const id = parseInt(req.params.id);

  try {
    const query = `SELECT * FROM cursos WHERE id = ?`;
    db.query(query, [id], (err, result) => {
      if (err) {
		  return res.status(500).json({ error: "Erro ao buscar curso" });
		}

      let curso;

		if (result.length > 0) {
		  // Se houver cursos no resultado, mapeia e converte os módulos de JSON string para objeto
		  curso = result.map(c => ({
		    ...c,
		    modulos: JSON.parse(c.modulos || "[]"), // Garante que a string JSON seja convertida em um array
		  }));
		} else {
		  // Caso contrário, retorna um curso padrão
		  curso = [{
		    id: 10000,
		    titulo: "Título Padrão",
		    titulo: "Img Padrão",
		    total_aulas: 0,
		    aulas_concluidas: 0,
		    modulos: [], // Nenhum módulo por padrão
		  }];
		}


      res.setHeader("Content-Type", "application/json");
      res.send(JSON.stringify({ curso }, null, 2)); // Formata com 2 espaços
    });
  } catch {
    res.status(500).json({ error: "Erro inesperado" });
  }
});

// Endpoint para buscar todos os cursos
app.get("/api/cursos", async (req, res) => {
  try {
    const query = `SELECT * FROM cursos`;
    db.query(query, (err, result) => {
      if (err) {
        return res.status(500).json({ error: "Erro ao buscar cursos" });
      }

      const cursos = result.map(c => ({
        ...c,
        modulos: JSON.parse(c.modulos || "[]"), // Garante que a string JSON seja convertida em array
      }));

      res.setHeader("Content-Type", "application/json");
      res.send(JSON.stringify({ cursos }, null, 2));
    });
  } catch {
    res.status(500).json({ error: "Erro inesperado" });
  }
});






// Iniciar o servidor
app.listen(PORT, () => {
  console.log(`Servidor rodando na porta ${PORT}`);
});