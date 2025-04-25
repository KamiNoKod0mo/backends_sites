"use client";

import { useEffect, useState } from "react";
import styles from "./page.module.css";
import Image from "next/image";
import Link from "next/link";

export default function Home() {
  const [cursos, setCursos] = useState([]);

  useEffect(() => {
    fetch("http://localhost:3001/api/cursos/")
      .then(async res => {
        const text = await res.text();
        console.log("Resposta bruta da API:", text); // 👀 Depuração
        try {
          return JSON.parse(text);
        } catch (error) {
          console.error("Erro ao converter resposta para JSON:", error);
          return null;
        }
      })
      .then(data => {
        if (data) setCursos(data.cursos);
      })
      .catch(error => console.error("Erro ao buscar cursos:", error));
  }, []);

  return (
    <div>
      <header></header>

      <section className={`${styles.container}`}>
        <div className={`${styles.top} ${styles.flex}`}>
          <div>
            <h4>Cursos da comunidade</h4>
            <p>Home &gt;</p>
          </div>

          <form>
            <select>
              <option>Todos os cursos</option>
              <option>Programação</option>
              <option>TI</option>
            </select>
            <input type="submit" name="filter" value="Filtrar" />
          </form>

          <form>
            <input type="text" name="search" placeholder="Palavra-chave ou nome do curso" />
            <input type="submit" name="sub_search" value="Buscar" />
          </form>
        </div>

        <div className={`${styles.cursos} ${styles.flex}`}>
          {cursos.map(curso => (
            <div key={curso.id} className={`${styles.single__curso}`}>
              <div className={`${styles.cover}`}>
                <Image src={curso.img} width={200} height={100} alt={curso.titulo} />
              </div>
              <div className={`${styles.title}`}>
                <h5>{curso.titulo}</h5>
              </div>
              <div className={`${styles.link}`}>
                <Link href={`/play?id=${curso.id}`}>Acessar o curso</Link>
              </div>
            </div>
          ))}
        </div>
      </section>
    </div>
  );
}
