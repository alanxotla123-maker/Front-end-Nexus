    <!-- Modal para Editar Juego -->
    <div id="edit-game-modal" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Editar Videojuego</h2>
                <span class="close-edit-modal">&times;</span>
            </div>
            <form id="edit-game-form">
                <input type="hidden" id="edit_id" name="id">
                <div class="form-group">
                    <label for="edit_titulo">Título</label>
                    <input type="text" id="edit_titulo" name="titulo" required placeholder="Nombre del juego">
                </div>
                <div class="form-group">
                    <label for="edit_descripcion">Descripción / Género</label>
                    <textarea id="edit_descripcion" name="descripcion" required placeholder="Breve descripción"></textarea>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="edit_precio">Precio ($)</label>
                        <input type="number" step="0.01" id="edit_precio" name="precio" required placeholder="0.00">
                    </div>
                    <div class="form-group">
                        <label for="edit_clasificacion">Clasificación</label>
                        <select id="edit_clasificacion" name="clasificacion">
                            <option value="E">Everyone (E)</option>
                            <option value="E10+">Everyone 10+</option>
                            <option value="T">Teen (T)</option>
                            <option value="M">Mature (M)</option>
                            <option value="AO">Adults Only</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="edit_video_path">URL del Video (Trailer)</label>
                    <input type="text" id="edit_video_path" name="video_path" placeholder="https://youtube.com/...">
                </div>
                <div class="form-group">
                    <label for="edit_imagen">URL de la Imagen (Portada)</label>
                    <input type="text" id="edit_imagen" name="imagen" placeholder="../imagenes/portada.jpg">
                </div>
                <button type="submit" class="btn-solid" style="width: 100%; margin-top: 10px;">ACTUALIZAR VIDEOJUEGO</button>
            </form>
        </div>
    </div>
