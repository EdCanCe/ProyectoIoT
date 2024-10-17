from flask import Flask, render_template
from flask_sqlalchemy import SQLAlchemy
from sqlalchemy import text  # Asegúrate de importar text

app = Flask(__name__)

# Configura la URI de la base de datos
app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql+mysqlconnector://root:@localhost/sql_tarea_1'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False

# Inicializa la base de datos
db = SQLAlchemy(app)

# Modelo para la tabla Video
class Video(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    titulo = db.Column(db.String(100), nullable=False)
    descripcion = db.Column(db.String(255))
    fecha_publicacion = db.Column(db.DateTime)

    def __repr__(self):
        return f'<Video {self.titulo}>'

@app.route('/')
def mostrar_videos():
    resultados = db.session.execute(text("SELECT * FROM video")).fetchall()  # Consulta todos los videos
    return render_template('index.html', resultados=resultados)

if __name__ == '__main__':
    app.run(debug=True)
