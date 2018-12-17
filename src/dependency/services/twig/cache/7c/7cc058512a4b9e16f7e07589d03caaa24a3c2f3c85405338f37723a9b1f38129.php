<?php

/* layout.twig */
class __TwigTemplate_fdf237a9554fbc3084bf05a85d713ffb213f40e0f8e2f5489aded4502230a58f extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = array(
            'body' => array($this, 'block_body'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html>
<head>
    <meta charset=\"utf-8\">
    <title>菜鸟教程(runoob.com)</title>
</head>
<body>
<h1>我的第一个标题</h1>
<p>我的第一个段落。</p>
";
        // line 10
        $this->displayBlock('body', $context, $blocks);
        // line 13
        echo "</body>
</html>";
    }

    // line 10
    public function block_body($context, array $blocks = array())
    {
        // line 11
        echo "
";
    }

    public function getTemplateName()
    {
        return "layout.twig";
    }

    public function getDebugInfo()
    {
        return array (  45 => 11,  42 => 10,  37 => 13,  35 => 10,  24 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "layout.twig", "D:\\program project\\web project\\slim3-framework-restful\\src\\dependency\\services\\twig\\views\\layout.twig");
    }
}
