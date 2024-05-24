<main class="container d-flex justify-content-center align-items-center mt-3">

    <div class="card" style="width: 32rem;">
        <div class="card-header p-3">
            <h5 class="card-title text-center">Formulario</h5>
        </div>
        <div class="card-body">

            <form action="/" method="POST" class="row g-3">
                <div class="mb-3">
                    <label for="name" class="form-label">Nombre</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="name" 
                        name="name" 
                        value="<?= isset($data['name']) ? $data['name'] : "" ?>">
                    <?php if (isset($errors['name'])) :?>
                        <div id="errorName" class="form-text text-white bg-danger rounded px-2 py-1">
                            <?= $errors['name'] ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <label for="mail" class="form-label">Correo Electronico</label>
                    <input 
                        type="email" 
                        class="form-control" 
                        id="mail" 
                        name="mail" 
                        value="<?= isset($data['mail']) ? $data['mail'] : "" ?>">
                    <?php if (isset($errors['mail'])) :?>
                        <div class="form-text text-white bg-danger rounded px-2 py-1">
                            <?= $errors['mail'] ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <select name="region" id="region" class="form-select" aria-label="selecciona una región">
                        <option selected disabled>Seleccioné una región</option>
                    </select>
                    <?php if (isset($errors['region'])) :?>
                        <div class="form-text text-white bg-danger rounded px-2 py-1">
                            <?= $errors['region'] ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <select name="comuna" id="comuna" class="form-select" aria-label="selecciona una comuna" disabled>
                        <option selected disabled>Seleccioné una comuna</option>
                    </select>
                    <?php if (isset($errors['comuna']) && $errors['comuna'] != "") :?>
                        <div class="form-text text-white bg-danger rounded px-2 py-1">
                            <?= $errors['comuna'] ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="mb-3 d-flex justify-content-between">
                    <button class="btn btn-primary" type="submit">Enviar</button>
                    <?php if (isset($_SESSION['success'])) : ?>
                        <div class="form-text text-success rounded px-2 py-1 fw-bold">Inscrito correctamente!!!</div>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
</main>