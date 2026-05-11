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
                    <div class="input-group">
                        <input type="text" id="titulo" name="titulo" required placeholder="Nombre del juego">
                        <svg viewBox="0 0 24 24">
                            <rect x="2" y="6" width="20" height="12" rx="2" ry="2"></rect>
                            <line x1="6" y1="12" x2="10" y2="12"></line>
                            <line x1="8" y1="10" x2="8" y2="14"></line>
                            <circle cx="15" cy="12" r="1"></circle>
                            <circle cx="18" cy="10" r="1"></circle>
                        </svg>
                    </div>
                </div>
                <div class="form-group">
                    <label for="descripcion">Descripción / Género</label>
                    <div class="input-group">
                        <textarea id="descripcion" name="descripcion" required placeholder="Breve descripción"></textarea>
                        <svg viewBox="0 0 24 24">
                            <line x1="17" y1="10" x2="3" y2="10"></line>
                            <line x1="21" y1="6" x2="3" y2="6"></line>
                            <line x1="21" y1="14" x2="3" y2="14"></line>
                            <line x1="17" y1="18" x2="3" y2="18"></line>
                        </svg>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="precio">Precio ($)</label>
                        <div class="input-group">
                            <input type="number" step="0.01" id="precio" name="precio" required placeholder="0.00">
                            <svg viewBox="0 0 24 24">
                                <line x1="12" y1="1" x2="12" y2="23"></line>
                                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="clasificacion">Clasificación</label>
                        <div class="input-group">
                            <select id="clasificacion" name="clasificacion">
                                <option value="E">Everyone (E)</option>
                                <option value="E10+">Everyone 10+</option>
                                <option value="T">Teen (T)</option>
                                <option value="M">Mature (M)</option>
                                <option value="AO">Adults Only</option>
                            </select>
                            <svg viewBox="0 0 24 24">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="video_path">URL del Video (Trailer)</label>
                    <div class="input-group">
                        <input type="text" id="video_path" name="video_path" placeholder="https://youtube.com/...">
                        <svg viewBox="0 0 24 24">
                            <rect x="2" y="2" width="20" height="20" rx="2.18" ry="2.18"></rect>
                            <line x1="7" y1="2" x2="7" y2="22"></line>
                            <line x1="17" y1="2" x2="17" y2="22"></line>
                            <line x1="2" y1="12" x2="22" y2="12"></line>
                            <line x1="2" y1="7" x2="7" y2="7"></line>
                            <line x1="2" y1="17" x2="7" y2="17"></line>
                            <line x1="17" y1="17" x2="22" y2="17"></line>
                            <line x1="17" y1="7" x2="22" y2="7"></line>
                        </svg>
                    </div>
                </div>
                <div class="form-group">
                    <label>Plataformas y Stock</label>
                    <div id="plataformas-container" style="display: flex; flex-direction: column; gap: 10px; margin-bottom: 10px;">
                        <div class="plataforma-row" style="display: flex; gap: 10px; align-items: center;">
                            <input type="text" name="plataforma[]" placeholder="Ej: PS5, PC, Xbox" style="flex: 2;">
                            <input type="number" name="stock[]" placeholder="Stock" style="flex: 1;" min="0">
                            <button type="button" class="remove-platform" style="background: rgba(255,0,0,0.1); border: 1px solid rgba(255,0,0,0.2); color: #ff4d4d; border-radius: 6px; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; cursor: pointer;">×</button>
                        </div>
                    </div>
                    <button type="button" id="add-platform-btn" style="background: rgba(0,240,255,0.05); border: 1px solid rgba(0,240,255,0.2); color: var(--accent-cyan); padding: 8px; border-radius: 6px; font-size: 11px; font-weight: 600; width: 100%; cursor: pointer;">+ AGREGAR PLATAFORMA</button>
                </div>
                <div class="form-group">
                    <label for="imagen">URL de la Imagen (Portada)</label>
                    <div class="input-group">
                        <input type="text" id="imagen" name="imagen" placeholder="../imagenes/portada.jpg">
                        <svg viewBox="0 0 24 24">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                            <circle cx="8.5" cy="8.5" r="1.5"></circle>
                            <polyline points="21 15 16 10 5 21"></polyline>
                        </svg>
                    </div>
                </div>
                <button type="submit" class="btn-solid" style="width: 100%; margin-top: 10px;">GUARDAR VIDEOJUEGO</button>
            </form>
        </div>
    </div>
