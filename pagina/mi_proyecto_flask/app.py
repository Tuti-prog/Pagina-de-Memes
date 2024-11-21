from flask import Flask, render_template, request, redirect, url_for, flash
import re

app = Flask(__name__)
app.secret_key = "mi_clave_secreta"  # Necesario para usar flash messages

# Ruta para el formulario de registro
@app.route('/registro', methods=['GET', 'POST'])
def registro():
    if request.method == 'POST':
        # Obtener los datos del formulario
        username = request.form['username']
        email = request.form['email']
        password = request.form['password']
        confirm_password = request.form['confirm_password']

        # Validación de los campos
        if not username or not email or not password or not confirm_password:
            flash("Todos los campos son obligatorios.")
            return redirect(url_for('registro'))

        if password != confirm_password:
            flash("Las contraseñas no coinciden.")
            return redirect(url_for('registro'))

        # Validación del formato de correo electrónico
        email_regex = r'^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$'
        if not re.match(email_regex, email):
            flash("El correo electrónico no es válido.")
            return redirect(url_for('registro'))

        # Si las validaciones son correctas, mostrar mensaje de éxito
        flash("Usuario registrado con éxito.")
        # Aquí podrías insertar los datos en la base de datos si es necesario
        return redirect(url_for('registro'))  # Redirige a la página de registro o inicio
    
    return render_template('registro.html')

if __name__ == '__main__':
    app.run(debug=True)
