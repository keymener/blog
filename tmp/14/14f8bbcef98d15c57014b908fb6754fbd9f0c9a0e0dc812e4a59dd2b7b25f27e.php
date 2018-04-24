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
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html lang=\"fr\">

    <head>

        <meta charset=\"utf-8\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">
        <meta name=\"description\" content=\"\">
        <meta name=\"author\" content=\"\">

        <title>";
        // line 11
        $this->displayBlock('title', $context, $blocks);
        echo "</title>

        <!-- Bootstrap core CSS -->
        <link href=\"public/vendor/bootstrap/css/bootstrap.min.css\" rel=\"stylesheet\">

        <!-- Custom fonts for this template -->
        <link href=\"https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900\" rel=\"stylesheet\">
        <link href=\"https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i\" rel=\"stylesheet\">

        <!-- Custom styles for this template -->
        <link href=\"public/css/one-page-wonder.min.css\" rel=\"stylesheet\">
        <link href=\"public/css/style.css\" rel=\"stylesheet\">
        
        

    </head>

    <body>
        <nav class=\"navbar navbar-expand-lg navbar-dark navbar-custom fixed-top\">
            <div class=\"container\">
                <a class=\"navbar-brand\" href=\"#\">Keigo Matsunaga</a>
                <button class=\"navbar-toggler\" type=\"button\" data-toggle=\"collapse\" data-target=\"#navbarResponsive\" aria-controls=\"navbarResponsive\" aria-expanded=\"false\" aria-label=\"Toggle navigation\">
                    <span class=\"navbar-toggler-icon\"></span>
                </button>
                <div class=\"collapse navbar-collapse\" id=\"navbarResponsive\">
                    <ul class=\"navbar-nav ml-auto\">
                        <li class=\"nav-item\">
                            <a class=\"nav-link\" href=\"#\">Blog</a>
                        </li>
                        <li class=\"nav-item\">
                            <a class=\"nav-link\" href=\"#\">Log In</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Content -->
        <div class=\"content\">

        ";
        // line 50
        $this->displayBlock('content', $context, $blocks);
        // line 51
        echo "
    </div>
    <!-- Footer -->
    <footer class=\"py-5 bg-black\">
        <div class=\"container\">
            <p class=\"m-0 text-center text-white small\">Copyright &copy; Keigo Matsunaga 2018</p>
        </div>
        <!-- /.container -->
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src=\"vendor/jquery/jquery.min.js\"></script>
    <script src=\"vendor/bootstrap/js/bootstrap.bundle.min.js\"></script>

</body>

</html>

";
    }

    // line 11
    public function block_title($context, array $blocks = array())
    {
    }

    // line 50
    public function block_content($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "homePageTemplate.twig";
    }

    public function getDebugInfo()
    {
        return array (  108 => 50,  103 => 11,  81 => 51,  79 => 50,  37 => 11,  25 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "homePageTemplate.twig", "C:\\wamp64\\www\\myblog\\view\\homePageTemplate.twig");
    }
}
