<?php

/* homePageTemplate.twig */
class __TwigTemplate_4583b1bd33b2c8533a512206fc4a8eb3fbd0328e3d397278c7b035b79fef52d0 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = array(
            'content' => array($this, 'block_content'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html>
    <head>
        <meta charset=\"UTF-8\">
        <title>test</title>
    </head>
    <body>
       ";
        // line 8
        $this->displayBlock('content', $context, $blocks);
        // line 9
        echo "    </body>
</html>
";
    }

    // line 8
    public function block_content($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "homePageTemplate.twig";
    }

    public function getDebugInfo()
    {
        return array (  41 => 8,  35 => 9,  33 => 8,  24 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "homePageTemplate.twig", "C:\\wamp64\\www\\myblog\\view\\homePageTemplate.twig");
    }
}
