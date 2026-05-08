    <!-- Modal para Agregar Juego -->
    <div id="game-modal" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Registrar Nuevo Videojuego</h2>
                <span class="close-modal">&times;</span>
            </div>
            <form id="add-game-form">
                <div class="form-group">
                    <label for="titulo">Título</label>
                    <input type="text" id="titulo" name="titulo" required placeholder="Nombre del juego">
                </div>
                <div class="form-group">
                    <label for="descripcion">Descripción / Género</label>
                    <textarea id="descripcion" name="descripcion" required placeholder="Breve descripción"></textarea>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="precio">Precio ($)</label>
                        <input type="number" step="0.01" id="precio" name="precio" required placeholder="0.00">
                    </div>
                    <div class="form-group">
                        <label for="clasificacion">Clasificación</label>
                        <select id="clasificacion" name="clasificacion">
                            <option value="E">Everyone (E)</option>
                            <option value="E10+">Everyone 10+</option>
                            <option value="T">Teen (T)</option>
                            <option value="M">Mature (M)</option>
                            <option value="AO">Adults Only</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="video_path">URL del Video (Trailer)</label>
                    <input type="text" id="video_path" name="video_path" placeholder="https://youtube.com/...">
                </div>
                <div class="form-group">
                    <label for="imagen">URL de la Imagen (Portada)</label>
                    <input type="text" id="imagen" name="imagen" placeholder="../imagenes/portada.jpg">
                </div>
                <button type="submit" class="btn-solid" style="width: 100%; margin-top: 10px;">GUARDAR VIDEOJUEGO</button>
            </form>
        </div>
    </div>
