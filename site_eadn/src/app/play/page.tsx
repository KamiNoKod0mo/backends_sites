"use client";

import { useEffect, useState } from "react";
import styles from "./page.module.css";
import Image from "next/image";
import Link from 'next/link';

import { useSearchParams } from "next/navigation"; // Importe useSearchParams



export default function Aula() {
  const [curso, setCurso] = useState([]);
  const searchParams = useSearchParams(); // Captura os parâmetros de consulta
  const id = searchParams.get("id"); // Extrai o `id` da query

  console.log("ID da URL:", id); //  Depuração

  useEffect(() => {
    if (id) {
      // Faz a requisição para a API com o ID do curso
      fetch(`http://localhost:3001/api/curso/${id}`)
        .then(async (res) => {
          const text = await res.text();
          //console.log("Resposta bruta da API:", text); // Depuração
          try {
            return JSON.parse(text);
          } catch (error) {
            //console.error("Erro ao converter resposta para JSON:", error);
            return null;
          }
        })
        .then((data) => {
          if (data) setCurso(data.curso); // Acessa o primeiro item do array `curso`
        })
        .catch((error) => console.error("Erro ao buscar curso:", error));
    }
  }, [id]); // Dependência: refaz a requisição se o ID mudar

  if (!curso) {
    return <div>Carregando...</div>; // Exibe uma mensagem enquanto os dados são carregados
  }



  return (
    <div>
      <header></header>



      <section className={`${styles.container}`}>
        {curso.map(curso => (
          <div className={`${styles.top} ${styles.flex}`}>
          <div>

            <h4>Título da Aula</h4>
            <p><Link href="/">Home</Link> &gt; Título do Módulo</p>
          </div>

          <button class={styles.prev}>&lt;</button>
          <button class={styles.next}>&gt;</button>

          <button className={styles.finish}>Aula concluída</button>
          </div>
         ))}
        

        <div className={`${styles.aula} ${styles.flex}`}>
          <div className={styles.aula__player}>
            <video width="100%" height="100%" controls>
              <source src="movie.mp4" type="video/mp4" />
              Seu navegador não suporta este formato de vídeo.
            </video>
          </div>

          <div className={styles.aula__painel}>
            <div className={styles.aula__painel__infos}>
              <div className={styles.progress}>
                <p>Progresso total do curso</p>
                <p>100%</p>
                <div className={styles.progress__bar}></div>
              </div>

              <button className={styles.reinit}>Reiniciar progresso</button>

              <form>
                <input type="text" name="search_aula" placeholder="Pesquisar aula" />
                <button>
                  <Image src="/imgs/search.png" alt="Buscar" width={20} height={20} />
                </button>
              </form>
            </div>

            <div className={styles.aula__painel__mods}>
              <div className={styles.modulo}>
                <h5>Nome do módulo</h5>
                <ul>
                  <li>Nome da aula</li>
                  <li>Nome da aula</li>
                  <li>Nome da aula</li>
                  <li>Nome da aula</li>
                </ul>
              </div>

              <div className={styles.modulo}>
                <h5>Nome do módulo</h5>
                <ul>
                  <li>Nome da aula</li>
                  <li>Nome da aula</li>
                  <li>Nome da aula</li>
                  <li>Nome da aula</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  );
}
