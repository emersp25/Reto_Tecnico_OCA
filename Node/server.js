import { createServer } from 'node:http';
import { Server } from 'socket.io';

export function crearServidor() {
  const httpServer = createServer();
  const io = new Server(httpServer, { cors: { origin: '*' } });

  io.on('connection', (socket) => {
    // el cliente manda su id al conectarse: io(url, { auth: { clienteId: 1 } })
    const { clienteId } = socket.handshake.auth;
    socket.join(`cliente:${clienteId}`);
  });

  // Se llama cuando se registra un pago: solo le llega a los sockets de esa sala
  function pagoRegistrado(clienteId, pago) {
    io.to(`cliente:${clienteId}`).emit('pago:registrado', pago);
  }

  return { httpServer, io, pagoRegistrado };
}
