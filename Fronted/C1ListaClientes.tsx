import { useEffect, useState } from 'react';
import axios from 'axios';

// Causa: el arreglo de dependencias estaba vacío ([]), así que el efecto
// solo corría al montar el componente. Hay que poner filtro ahí para que vuelva a consultar cada vez que cambie.
export function ListaClientes({ filtro }: { filtro: string }) {
  const [clientes, setClientes] = useState<{ id: number; nombre: string }[]>([]);

  useEffect(() => {
    axios.get(`/api/clientes?filtro=${filtro}`).then((res) => {
      setClientes(res.data);
    });
  }, [filtro]);

  return (
    <ul>{clientes.map((c) => <li key={c.id}>{c.nombre}</li>)}</ul>
  );
}
