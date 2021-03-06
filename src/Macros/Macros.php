<?php

namespace WebChemistry\Images\Macros;

use Latte;

class Macros extends Latte\Macros\MacroSet {
    
    public static function install(Latte\Compiler $compiler) {
        $me = new static($compiler);
        
        $me->addMacro('img', [$me, 'beginImg'], NULL, [$me, 'attrImg']);
        $me->addMacro('imgLink', [$me, 'beginLink'], NULL, [$me, 'attrLink']);
    }
    
    public function beginLink(Latte\MacroNode $node, Latte\PhpWriter $writer) {
        return $writer->write('echo %escape($_control->link(":ImageStorage:Generate:", %node.array));');
    }
    
    public function attrLink(Latte\MacroNode $node, Latte\PhpWriter $writer) {
        if ($node->htmlNode->name === 'a') {
            $attr = 'href=';
        } else {
            $attr = 'src=';
        }
        
        return $writer->write('echo \' ' . $attr . '"\' . %escape($_control->link(":ImageStorage:Generate:", %node.array)) . \'"\'');
    }
    
    public function beginImg(Latte\MacroNode $node, Latte\PhpWriter $writer) {
        return $writer->write('$__image = $imageStorage->create(%node.args); echo ($__image->isBaseUri() ? $baseUri : $basePath) . "/" . $__image->createLink();');
    }
    
    public function attrImg(Latte\MacroNode $node, Latte\PhpWriter $writer) {
        if ($node->htmlNode->name === 'a') {
            $attr = 'href=';
        } else {
            $attr = 'src=';
        }
        
        return $writer->write('$__image = $imageStorage->create(%node.args);echo \' ' . $attr . '"\' . ($__image->isBaseUri() ? $baseUri : $basePath) . "/" . $__image->createLink() . \'"\'');
    }
}
