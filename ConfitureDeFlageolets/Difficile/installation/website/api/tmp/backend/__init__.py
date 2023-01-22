# -*- coding: utf-8 -*-

from flask import Flask, jsonify
from flask_cors import CORS
from flask_sqlalchemy import SQLAlchemy
from werkzeug.exceptions import HTTPException


db = SQLAlchemy()

app = Flask(__name__)
CORS(app)

# Choix de la clé secrète : 
# 50 caractères donc 8575979590420267008 possibilités
# => Même en faisant 10^10 key/s (irréaliste) il faudrait presque 10000 jours complets
app.config['SECRET_KEY']='kWIIEGkCP7TGtnh7dRH2jr7wcpJPABdXYSWAgBvZ8Z8Pb7sXrD'
app.config['SQLALCHEMY_DATABASE_URI']='sqlite:///db.sqlite'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = True

db.init_app(app)


# ----- Error Handlers ----- #

@app.errorhandler(Exception)
def handle_error(e):
    code = 500
    if isinstance(e, HTTPException):
        code = e.code
    return jsonify(error=str(e)), code


# ----- Blueprints ----- #

from .auth import auth as auth_blueprint
app.register_blueprint(auth_blueprint)

from .main import main as main_blueprint
app.register_blueprint(main_blueprint)



if __name__ == '__main__':
	app.run(port=8080)

