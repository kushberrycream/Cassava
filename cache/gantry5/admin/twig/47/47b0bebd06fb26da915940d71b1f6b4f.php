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

/* @gantry-admin/pages/about/about.html.twig */
class __TwigTemplate_f894e4590649b26202242da68496280d extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'gantry' => [$this, 'block_gantry'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return $this->loadTemplate((((($context["ajax"] ?? null) - ($context["suffix"] ?? null))) ? ("@gantry-admin/partials/ajax.html.twig") : ("@gantry-admin/partials/base.html.twig")), "@gantry-admin/pages/about/about.html.twig", 1);
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $this->getParent($context)->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_gantry($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 4
        echo "    <div class=\"g-grid overview-header\">
        <div class=\"g-block\">
            <h2 class=\"theme-title\">
                ";
        // line 7
        if (twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "theme", [], "any", false, false, false, 7), "icon", [], "any", false, false, false, 7)) {
            echo "<i class=\"fa fa-";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "theme", [], "any", false, false, false, 7), "icon", [], "any", false, false, false, 7), "html", null, true);
            echo "\" aria-hidden=\"true\"></i>";
        }
        echo " ";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "theme", [], "any", false, false, false, 7), "title", [], "any", false, false, false, 7), "html", null, true);
        echo "
            </h2>
            <span class=\"theme-version\">v";
        // line 9
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "theme", [], "any", false, false, false, 9), "version", [], "any", false, false, false, 9), "html", null, true);
        echo "</span>
            <div>";
        // line 10
        echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->transFilter("GANTRY5_PLATFORM_BY"), "html", null, true);
        echo " <a href=\"";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "theme", [], "any", false, false, false, 10), "author", [], "any", false, false, false, 10), "link", [], "any", false, false, false, 10), "html", null, true);
        echo "\" aria-label=\"Template Author's Website\" tabindex=\"1\">";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "theme", [], "any", false, false, false, 10), "author", [], "any", false, false, false, 10), "name", [], "any", false, false, false, 10), "html", null, true);
        echo "</a></div>
        </div>
        <div class=\"g-block\">
            <span class=\"float-right\">
                <button class=\"button button-back-to-conf\"><i class=\"fa fa-fw fa-arrow-left\" aria-hidden=\"true\"></i> <span>";
        // line 14
        echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->transFilter("GANTRY5_PLATFORM_BACK_SETUP"), "html", null, true);
        echo "</span></button>
                <a href=\"";
        // line 15
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "theme", [], "any", false, false, false, 15), "support", [], "any", false, false, false, 15), "link", [], "any", false, false, false, 15), "html", null, true);
        echo "\" class=\"button button-primary\"><i class=\"fa fa-support\" aria-hidden=\"true\"></i> <span>";
        echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->transFilter("GANTRY5_PLATFORM_SUPPORT"), "html", null, true);
        echo "</span></a>
                <a href=\"";
        // line 16
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "theme", [], "any", false, false, false, 16), "documentation", [], "any", false, false, false, 16), "link", [], "any", false, false, false, 16), "html", null, true);
        echo "\" class=\"button button-primary\"><i class=\"fa fa-book\" aria-hidden=\"true\"></i> <span>";
        echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->transFilter("GANTRY5_PLATFORM_DOCUMENTATION"), "html", null, true);
        echo "</span></a>
            </span>
        </div>
    </div>

    <div class=\"g-grid overview-details\">
        <div class=\"g-block size-35\">
             <img src=\"";
        // line 23
        echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->urlFunc(twig_get_attribute($this->env, $this->source, ($context["info"] ?? null), "thumbnail", [], "any", false, false, false, 23)), "html", null, true);
        echo "\" class=\"preview-image\" alt=\"\">
        </div>

        <div class=\"g-block\">
            <p>Hydrogen is the default theme for the Gantry 5 framework. It features a lightweight design and basic configuration settings to help get acquainted with Gantry 5's many features and options.</p>
            <ul class=\"overview-list\">
                <li><i class=\"fa fa-asterisk\" aria-hidden=\"true\"></i>Clean, minimalistic design</li>
                <li><i class=\"fa fa-asterisk\" aria-hidden=\"true\"></i>Fast and lightweight</li>
                <li><i class=\"fa fa-asterisk\" aria-hidden=\"true\"></i>Includes preset styles and outlines</li>
            </ul>
        </div>
    </div>

    ";
        // line 36
        $this->loadTemplate("@gantry-admin/partials/gantry-details.html.twig", "@gantry-admin/pages/about/about.html.twig", 36)->display($context);
    }

    public function getTemplateName()
    {
        return "@gantry-admin/pages/about/about.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  118 => 36,  102 => 23,  90 => 16,  84 => 15,  80 => 14,  69 => 10,  65 => 9,  54 => 7,  49 => 4,  45 => 3,  35 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "@gantry-admin/pages/about/about.html.twig", "C:\\MAMP\\htdocs\\cassava.nri.org\\administrator\\components\\com_gantry5\\templates\\pages\\about\\about.html.twig");
    }
}
