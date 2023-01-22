from flask import Blueprint, request, make_response, current_app, jsonify
from werkzeug.security import generate_password_hash, check_password_hash
import uuid, datetime, jwt
from .models import User
from .middlewares import need_json
from . import db

auth = Blueprint('auth', __name__)


@auth.route('/register', methods=['POST'])
@need_json(['pseudo', 'password'])
def register(req):
	password, pseudo = map(req.get, ['password', 'pseudo'])

	if pseudo=='' or password=='':
		return jsonify({
			'status': 'error',
			'message': 'Empty fields are not allowed'
		})

	if User.query.filter_by(pseudo=pseudo).first():
		return jsonify({
			'status': 'error',
			'message': 'Pseudo already exists'
		})

	# add a new user to the database
	user = User(id=str(uuid.uuid4()), pseudo=pseudo, password=generate_password_hash(password, method='sha256'))
	db.session.add(user)
	db.session.commit()

	token = jwt.encode({'id': user.id, 'exp' : datetime.datetime.utcnow() + datetime.timedelta(minutes=30)}, current_app.config['SECRET_KEY'])

	return jsonify({
		'status': 'success',
		'token' : token.decode('UTF-8'),
		'message': 'Registered successfully'
	})


@auth.route('/login', methods=['GET', 'POST'])
def login():
	auth = request.authorization
	if not auth or not auth.username or not auth.password:
		print("ERROR header")
		return make_response(jsonify({
			'status': 'error',
			'message': 'Authorization header is needed'
		}), 401, {'WWW.Authenticate': 'Basic realm="Login is required"'})

	user = User.query.filter_by(pseudo=auth.username).first()

	if user and check_password_hash(user.password, auth.password):
		token = jwt.encode({'id': user.id, 'exp' : datetime.datetime.utcnow() + datetime.timedelta(minutes=30)}, current_app.config['SECRET_KEY'])
		return jsonify({
			'status': 'success',
			'token' : token.decode('UTF-8')
		})

	print("ERROR login")
	return make_response(jsonify({
			'status': 'error',
			'message': 'Invalid username or password'
		}),  401, {'WWW.Authenticate': 'Basic realm="Login is required"'})
