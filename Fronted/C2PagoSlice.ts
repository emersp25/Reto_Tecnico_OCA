import { createAsyncThunk, createSlice } from '@reduxjs/toolkit';
import axios from 'axios';

// Thunk: hace el GET /pagos?cliente_id= y Redux dispara pending, fulfilled o rejected

export const fetchPagos = createAsyncThunk('pagos/fetchPagos', async (clienteId: number) => {
    const res = await axios.get('/pagos', { params: {cliente_id: clienteId} });
    return res.data;
});

const pagosSlice = createSlice({
    name: 'pagos',
    initialState: {
        items: [] as any[],
        loading: false,
        error: null as string | null,
    },
    reducers: {},
    extraReducers: (builder) => {
        builder
        .addCase(fetchPagos.pending, (state) => {
            state.loading = true; // mientras espera la respuesta
            state.error = null;
        })
        .addCase(fetchPagos.fulfilled, (state, action) => {
            state.loading = false;
            state.items = action.payload;
        })
        .addCase(fetchPagos.rejected, (state, action) => {
            state.loading = false;
            state.error = action.error.message ?? 'Error al cargar los pagos' ;
        });
    },
});

export default pagosSlice.reducer;
