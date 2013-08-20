<?php

namespace Less;

class importVisitor{

	public $_visitor;
	public $_importer;

	function __construct( $root, $importer = null ){
		$this->_visitor = new \Less\visitor($this);
		$this->_importer = $importer;
		$this->_visitor->visit($root);
		$this->env = new \Less\Environment();
	}

	function visitImport($importNode, $visitArgs ){
		/*
		if (!importNode.css) {
			importNode = importNode.evalForImport(this.env);
			this._importer.push(importNode.getPath(), function (e, root, imported) {
				if (e) { e.index = importNode.index; }
				if (imported && importNode.once) { importNode.skip = imported; }
				importNode.root = root || new(tree.Ruleset)([], []);
			});
		}
		visitArgs.visitDeeper = false;
		*/

		return $importNode;
	}

	function visitRule( $ruleNode, $visitArgs ){
		$visitArgs['visitDeeper'] = false;
		return $ruleNode;
	}

	function visitDirective($directiveNode, $visitArgs){
		array_unshift($this->env->frames,$directiveNode);
		return $directiveNode;
	}

	function visitDirectiveOut($directiveNode) {
		array_shift($this->env->frames);
	}

	function visitMixinDefinition($mixinDefinitionNode, $visitArgs) {
		array_unshift($this->env->frames,$mixinDefinitionNode);
		return $mixinDefinitionNode;
	}

	function visitMixinDefinitionOut($mixinDefinitionNode) {
		array_shift($this->env->frames);
	}

	function visitRulesetDefinition($rulesetNode, $visitArgs) {
		array_unshift($this->env->frames,$rulesetNode);
		return $rulesetNode;
	}

	function visitRulesetDefinitionOut($rulesetNode) {
		array_shift($this->env->frames);
	}

	function visitMedia($mediaNode, $visitArgs) {
		array_unshift($this->env->frames, $mediaNode->ruleset);
		return $mediaNode;
	}

	function visitMediaOut($mediaNode) {
		array_shift($this->env->frames);
	}
}