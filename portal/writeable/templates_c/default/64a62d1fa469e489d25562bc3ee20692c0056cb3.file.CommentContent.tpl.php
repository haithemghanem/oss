<?php /* Smarty version Smarty-3.1.19, created on 2019-05-18 21:42:09
         compiled from "C:\wamp\www\crm\portal\layouts\default\templates\Portal\partials\CommentContent.tpl" */ ?>
<?php /*%%SmartyHeaderCode:310775ce07c31eeb8f6-58623128%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '64a62d1fa469e489d25562bc3ee20692c0056cb3' => 
    array (
      0 => 'C:\\wamp\\www\\crm\\portal\\layouts\\default\\templates\\Portal\\partials\\CommentContent.tpl',
      1 => 1520231416,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '310775ce07c31eeb8f6-58623128',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5ce07c31ef3614_56208114',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ce07c31ef3614_56208114')) {function content_5ce07c31ef3614_56208114($_smarty_tpl) {?>


    <div class="row" ng-if="record.Status.toUpperCase()!=='CLOSED'">
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
            <form ng-submit="addComment(commentForm.$valid)" name="commentForm" novalidate="novalidate">
                <textarea msd-elastic style="resize:none;" name="comment" ng-model="newcomment.commentcontent" class="form-control text-left" placeholder="{{'Add your comment here'|translate}}..." rows="3" ng-required="true"></textarea>
                <span ng-if="!commentForm.$valid && commentValidate" class="text-danger">This field is required.</span>
                <br>
                <button type="submit" ng-disabled="savingComment" class="btn btn-success pull-right">{{'Submit'|translate}}</button>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 comment-list">
            <div class="row " ng-repeat="comment in comments | orderBy:'createdtime':true |limitTo:comments.length">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <p class="usertitle commnet-owner">
                        <b class="uname" ng-if="comment.creator.label!=='' && !comment.customer.label">{{comment.creator.label}}&nbsp;</b>
                        <b class="uname" ng-if="comment.creator.label!=='' && comment.customer.label">{{comment.customer.label}}&nbsp;</b>
                        <small class="utime">{{comment.createdtime}}</small>
                    </p>
                    <p class="comment-content" style="white-space: pre-line;">{{comment.commentcontent}}</p>
					<ul class="comment-docs">
						<li ng-repeat=" attachment in comment.attachments"><a><small ng-if="attachment.filename" ng-click="downloadCommentFile('ModComments',comment.id,attachment.attachmentid)">{{attachment.filename}} <i class="glyphicon glyphicon-download-alt comment-document" ng-click="downloadCommentFile('ModComments',comment.id,attachment.attachmentid)"></i></small></a></li>
					</ul>
                </div>
            </div>
            <a ng-if="!commentsLoaded && !noComments" ng-click="loadCommentsPage(commentPageNo)">{{'more'|translate}}...</a>
            <p ng-if="commentsLoaded" class="text-muted">{{'No more comments'|translate}}</p>
            <p ng-if="!commentsLoaded && noComments" class="text-muted">{{'No comments'|translate}}</p>
        </div>
    </div>

<?php }} ?>
