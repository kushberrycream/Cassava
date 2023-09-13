<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* partials/page_head.html.twig */
class __TwigTemplate_30c7e402d8a62ba34346bfe10ab934bf extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'head_title' => [$this, 'block_head_title'],
            'head_application' => [$this, 'block_head_application'],
            'head_platform' => [$this, 'block_head_platform'],
            'head' => [$this, 'block_head'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "@nucleus/page_head.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $this->parent = $this->loadTemplate("@nucleus/page_head.html.twig", "partials/page_head.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_head_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 4
        if (twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "platform", [], "any", false, false, false, 4), "checkVersion", [0 => 4], "method", false, false, false, 4)) {
            echo " ";
            // line 5
            echo "    <jdoc:include type=\"metas\" />
    ";
        }
    }

    // line 9
    public function block_head_application($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 10
        if (twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "platform", [], "any", false, false, false, 10), "checkVersion", [0 => 4], "method", false, false, false, 10)) {
            echo " ";
            // line 11
            echo "    <jdoc:include type=\"styles\" />
    <jdoc:include type=\"scripts\" />
    ";
        } elseif (twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source,         // line 13
($context["gantry"] ?? null), "platform", [], "any", false, false, false, 13), "checkVersion", [0 => 3], "method", false, false, false, 13)) {
            echo " ";
            // line 14
            echo "    <jdoc:include type=\"head\" />
    ";
        }
    }

    // line 18
    public function block_head_platform($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 19
        $this->displayParentBlock("head_platform", $context, $blocks);
        echo "
    ";
        // line 20
        if (twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "theme", [], "any", false, false, false, 20), "joomla", [], "any", false, false, false, 20)) {
            // line 21
            echo "        ";
            if (twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "platform", [], "any", false, false, false, 21), "checkVersion", [0 => 4], "method", false, false, false, 21)) {
                echo " ";
                // line 22
                echo "            ";
                if ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "page", [], "any", false, false, false, 22), "direction", [], "any", false, false, false, 22) != "rtl")) {
                    // line 23
                    echo "            <link rel=\"stylesheet\" href=\"";
                    echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->urlFunc("gantry-engine://css-compiled/bootstrap5.css"), "html", null, true);
                    echo "\" type=\"text/css\" />
            ";
                } else {
                    // line 25
                    echo "            <link rel=\"stylesheet\" href=\"";
                    echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->urlFunc("gantry-engine://css-compiled/bootstrap5-rtl.css"), "html", null, true);
                    echo "\" type=\"text/css\" />
            ";
                }
                // line 27
                echo "            <link rel=\"stylesheet\" href=\"";
                echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->urlFunc("media/system/css/joomla-fontawesome.min.css"), "html", null, true);
                echo "\" type=\"text/css\" />
        ";
            } elseif (twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source,             // line 28
($context["gantry"] ?? null), "platform", [], "any", false, false, false, 28), "checkVersion", [0 => 3], "method", false, false, false, 28)) {
                echo " ";
                // line 29
                echo "            <link rel=\"stylesheet\" href=\"";
                echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->urlFunc("gantry-assets://css/bootstrap-gantry.css"), "html", null, true);
                echo "\" type=\"text/css\" />
            <link rel=\"stylesheet\" href=\"";
                // line 30
                echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->urlFunc("gantry-engine://css-compiled/joomla.css"), "html", null, true);
                echo "\" type=\"text/css\" />
            ";
                // line 31
                if ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "page", [], "any", false, false, false, 31), "direction", [], "any", false, false, false, 31) == "rtl")) {
                    // line 32
                    echo "            <link rel=\"stylesheet\" href=\"";
                    echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->urlFunc("media/jui/css/bootstrap-rtl.css"), "html", null, true);
                    echo "\" type=\"text/css\" />
            ";
                }
                // line 34
                echo "            <link rel=\"stylesheet\" href=\"";
                echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->urlFunc("media/jui/css/icomoon.css"), "html", null, true);
                echo "\" type=\"text/css\" />
        ";
            }
            // line 36
            echo "    ";
        }
        // line 37
        echo "
    ";
        // line 38
        if (twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "debug", [], "any", false, false, false, 38)) {
            // line 39
            echo "        <link rel=\"stylesheet\" href=\"";
            echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->urlFunc("media/cms/css/debug.css"), "html", null, true);
            echo "\" type=\"text/css\" />
    ";
        }
    }

    // line 43
    public function block_head($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 44
        $this->displayParentBlock("head", $context, $blocks);
    }

    public function getTemplateName()
    {
        return "partials/page_head.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  162 => 44,  158 => 43,  150 => 39,  148 => 38,  145 => 37,  142 => 36,  136 => 34,  130 => 32,  128 => 31,  124 => 30,  119 => 29,  116 => 28,  111 => 27,  105 => 25,  99 => 23,  96 => 22,  92 => 21,  90 => 20,  86 => 19,  82 => 18,  76 => 14,  73 => 13,  69 => 11,  66 => 10,  62 => 9,  56 => 5,  53 => 4,  49 => 3,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "partials/page_head.html.twig", "C:\\MAMP\\htdocs\\cassava.nri.org\\media\\gantry5\\engines\\nucleus\\twig\\partials\\page_head.html.twig");
    }
}
