from flask import request, jsonify, current_app
from functools import wraps
import jwt
from .models import User

def need_token(f):
	@wraps(f)
	def decorator(*args, **kwargs):

		token = None

		if 'x-access-token' in request.headers:
			token = request.headers['x-access-token']

		if not token:
			return jsonify({'message': 'A token is required'})

		try:
			data = jwt.decode(token, current_app.config['SECRET_KEY'])
			current_user = User.query.filter_by(id=data['id']).first()
		except Exception as e:
			return jsonify({'message': e})

		return f(current_user, *args, **kwargs)
	return decorator


def need_json(*args):
	objects = args[0] if len(args)>0 and hasattr(args[0], '__iter__') else None

	def decorator(f):
		@wraps(f)
		def inner_decorator(*args, **kwargs):
			json = request.get_json()
			if not json:
				print 'Invalid JSON ' + repr(request.data)
				return jsonify({'message': 'JSON data is required'})

			if objects:
				missing = [o for o in objects if o not in json]
				if len(missing)>0:
					return jsonify({'message': 'Missing attribute'+('s' if len(missing)>1 else '')+' '+str(missing)[1:-1].replace("'", '')})

			return f(json, *args, **kwargs)
		return inner_decorator
	return decorator
