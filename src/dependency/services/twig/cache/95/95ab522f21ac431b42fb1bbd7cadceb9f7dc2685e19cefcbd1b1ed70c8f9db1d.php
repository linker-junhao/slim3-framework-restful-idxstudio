<?php

/* appCenter.twig */
class __TwigTemplate_194e17143701d7863913b02969423b054cdc598dc7175ef3d564f3562feee6c3 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("layout.twig", "appCenter.twig", 1);
        $this->blocks = array(
            'body' => array($this, 'block_body'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "layout.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_body($context, array $blocks = array())
    {
        // line 4
        echo "    <h1>User List</h1>
    <ul>
        <li><a href=\"";
        // line 6
        echo twig_escape_filter($this->env, $this->extensions['Slim\Views\TwigExtension']->pathFor("profile", array("name" => "josh")), "html", null, true);
        echo "\">Josh</a></li>
    </ul>
";
    }

    public function getTemplateName()
    {
        return "appCenter.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  39 => 6,  35 => 4,  32 => 3,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "appCenter.twig", "D:\\program project\\web project\\slim3-framework-restful\\src\\dependency\\services\\twig\\views\\appCenter.twig");
    }
}
