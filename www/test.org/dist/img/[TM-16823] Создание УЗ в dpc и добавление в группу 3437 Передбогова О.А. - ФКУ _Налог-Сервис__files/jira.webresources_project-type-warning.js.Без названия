;
/* module-key = 'jira.webresources:project-type-warning', location = '/static/projecttypes/warning/dialog/project-type-warning-dialog.js' */
define("jira/project/types/warning/dialog",["require"],function(e){"use strict";function t(t,a,r){var o=n(".project-type-warning-icon",r);i(o,"uninstalled-warning-dialog",function(i,r,o){return i.html(JIRA.Project.Types.Warning.dialog({title:t.title,firstParagraph:t.firstParagraph,secondParagraph:t.secondParagraph,callToActionText:t.callToActionText})),e("jira/project/admin/change-project-type-dialog")({trigger:n(".warning-dialog-change-project-type"),projectId:t.projectId,onProjectTypeChanged:a}),o(),!1},{width:375,gravity:"w"})}var n=e("jquery"),a=e("wrm/data"),i=e("aui/inline-dialog"),r=a.claim("project.type.warning.dialogs.data");return{init:function(e){e=e||{},e.sectionElement=e.sectionElement||n("body"),t(r,e.onProjectTypeChanged,e.sectionElement)}}});;
;
/* module-key = 'jira.webresources:project-type-warning', location = '/static/projecttypes/warning/dialog/templates/templates.soy' */
// This file was automatically generated from templates.soy.
// Please don't edit this file by hand.

/**
 * @fileoverview Templates in namespace JIRA.Project.Types.Warning.
 */

if (typeof JIRA == 'undefined') { var JIRA = {}; }
if (typeof JIRA.Project == 'undefined') { JIRA.Project = {}; }
if (typeof JIRA.Project.Types == 'undefined') { JIRA.Project.Types = {}; }
if (typeof JIRA.Project.Types.Warning == 'undefined') { JIRA.Project.Types.Warning = {}; }


JIRA.Project.Types.Warning.dialog = function(opt_data, opt_ignored) {
  return '<div class="project-type-warning-dialog"><p class="header"><span>' + soy.$$escapeHtml(opt_data.title) + '</span></p><p class="type-not-accessible-message">' + soy.$$escapeHtml(opt_data.firstParagraph) + '</p><p class="available-functionality-message">' + soy.$$escapeHtml(opt_data.secondParagraph) + '</p><div class="actions"><a class="warning-dialog-change-project-type" href="#">' + soy.$$escapeHtml(opt_data.callToActionText) + '</a></div></div>';
};
if (goog.DEBUG) {
  JIRA.Project.Types.Warning.dialog.soyTemplateName = 'JIRA.Project.Types.Warning.dialog';
}
;