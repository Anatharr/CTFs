from flask import Blueprint, jsonify, request
from xml.dom import pulldom
import uuid

from .middlewares import need_token, need_json
from .models import Comment
from .parser import safeParse
from . import db

main = Blueprint('main', __name__)

@main.route('/comments', methods=['GET'])
def get_comments():
    if not request.args or not request.args.get('article'):
        return jsonify({
            'status':'error',
            'message':'GET parameter \'article\' is required'
        })

    comments = [{
        'id': comment.id,
        'article': comment.article,
        'author': comment.author,
        'content': comment.content,
        'timestamp': comment.timestamp
    } for comment in Comment.query.filter_by(article=int(request.args.get('article'))).all()]

    return jsonify({'status': 'success', 'comments': comments})


@main.route('/comments', methods=['POST'])
@need_token
@need_json(['article', 'content'])
def post_comments(req, logged_user):
    article, content = map(lambda x: req[x], ['article', 'content'])

    if any(map(lambda x: x=='', [article, content])):
        return jsonify({
            'status': 'error',
            'message': 'Empty fields are not allowed'
        })

    # Remove all unwanted tags and attributes
    filteredContent = safeParse(content)


    author = logged_user.pseudo
    comment = Comment(id=str(uuid.uuid4()), article=int(article), author=author, content=filteredContent)
    db.session.add(comment)
    db.session.commit()

    return jsonify({'status': 'success', 'comment': {
        'id': comment.id,
        'article': comment.article,
        'author': comment.author,
        'content': comment.content,
        'timestamp': comment.timestamp
    }})


@main.route('/comments', methods=['DELETE'])
@need_token
@need_json(['id'])
def delete_comments(req, logged_user):
    comment = Comment.query.filter_by(id=req['id']).first()

    if comment is None:
        return jsonify({
            'status': 'error',
            'message': 'Unable to find comment ' + req['id']
        })

    if comment.author!=logged_user.pseudo:
        return jsonify({
            'status': 'error',
            'message': 'User ' + logged_user.pseudo + ' cannot delete this comment'
        })

    db.session.delete(comment)
    db.session.commit()

    return jsonify({
        'status': 'success',
        'message': 'Comment deleted successfully'
    })

