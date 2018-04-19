<?php

/* allPosts.twig */
class __TwigTemplate_45d5b6bb2c6e3354dffcb7ae8ae4862e63aaba8146964dde6476c2d8529830d8 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("homePageTemplate.twig", "allPosts.twig", 1);
        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "homePageTemplate.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = array())
    {
        echo "MBP - Les posts ";
    }

    // line 6
    public function block_content($context, array $blocks = array())
    {
        // line 7
        echo "    
    ";
        // line 8
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["posts"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["post"]) {
            // line 9
            echo "        <h1>";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["post"], "title", array()), "html", null, true);
            echo "</h1></br>
        <h2>";
            // line 10
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["post"], "chapeau", array()), "html", null, true);
            echo "</h2></br>
        <p>";
            // line 11
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["post"], "content", array()), "html", null, true);
            echo "</p>
        <p>écrit par ";
            // line 12
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["post"], "adminUser", array()), "html", null, true);
            echo " le ";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["post"], "lastDate", array()), "html", null, true);
            echo "</p>
   ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['post'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 14
        echo "
";
    }

    public function getTemplateName()
    {
        return "allPosts.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  72 => 14,  62 => 12,  58 => 11,  54 => 10,  49 => 9,  45 => 8,  42 => 7,  39 => 6,  33 => 3,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "allPosts.twig", "C:\\wamp64\\www\\myblog\\view\\allPosts.twig");
    }
}
