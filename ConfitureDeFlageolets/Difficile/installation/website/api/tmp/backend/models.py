from . import db

class User(db.Model):
    private_id = db.Column(db.Integer, primary_key=True)
    id         = db.Column(db.Integer, unique=True)
    pseudo     = db.Column(db.String(1000), unique=True)
    password   = db.Column(db.String(100))


class Comment(db.Model):
    private_id = db.Column(db.Integer, primary_key=True)
    id         = db.Column(db.Integer, unique=True)
    article    = db.Column(db.Integer)
    author     = db.Column(db.String(1000))
    content    = db.Column(db.String(100))
    timestamp  = db.Column(db.DateTime, server_default=db.func.now())
